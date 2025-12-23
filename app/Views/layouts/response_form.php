<?php
/**
 * Reusable response layout for forms
 * 
 * Required variables:
* - $pageTitle: Page title
* - $message: Main message to be displayed
* - $type: 'success' or 'error' (determines color and icon)
* - $redirectUrl: URL for redirection (optional)
* - $redirectTime: Time in ms for automatic redirection (default: 3000)
* - $showBackButton: If true, shows back button (default: true)
* - $backUrl: URL for the back button (optional)
 */

// Default values
$redirectTime = $redirectTime ?? 5000;
$showBackButton = $showBackButton ?? true;
$backUrl = $backUrl ?? 'javascript:history.back()';
$menuActive = $menuActive ?? '';

// Type-based settings
$icon = $type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';
$title = $type === 'success' ? 'Success!' : 'Error!';
$alertClass = $type === 'success' ? 'alert-success' : 'alert-danger';

$styles = <<<'HTML'
<style>
    html, body {
        margin: 0;
        padding: 0;
        height: 100%;
        overflow: hidden;
        background: #f6f9fb;
    }

    .container-fluid {
        padding: 0;
        height: 100vh;
    }

    .row {
        margin: 0;
        height: 100%;
    }

    .col-md-9 {
        height: calc(100vh - 56px);
        padding: 0;
        display: flex;
        flex-direction: column;
        overflow-y: auto;
        align-items: center;
        justify-content: center;
    }

    .response-container {
        max-width: 600px;
        width: 100%;
        padding: 20px;
    }

    .response-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        padding: 40px;
        text-align: center;
    }

    .response-icon {
        font-size: 4rem;
        margin-bottom: 20px;
    }

    .response-icon.success {
        color: #28a745;
    }

    .response-icon.error {
        color: #dc3545;
    }

    .response-title {
        color: #2c3e50;
        font-weight: 600;
        font-size: 1.8rem;
        margin-bottom: 15px;
    }

    .response-message {
        color: #495057;
        font-size: 1.1rem;
        line-height: 1.6;
        margin-bottom: 25px;
    }

    .response-details {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        margin: 20px 0;
        text-align: left;
    }

    .response-details pre {
        margin: 0;
        white-space: pre-wrap;
        word-wrap: break-word;
        font-family: monospace;
        font-size: 0.9rem;
    }

    .response-actions {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-top: 30px;
    }

    .btn-back {
        background-color: #6c757d;
        border-color: #6c757d;
        color: white;
        min-width: 150px;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        color: white;
        min-width: 150px;
    }

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
        color: white;
        min-width: 150px;
    }

    .countdown {
        margin-top: 20px;
        color: #6c757d;
        font-size: 0.9rem;
    }

    .countdown-number {
        font-weight: bold;
        color: #007bff;
    }

    @media (max-width: 768px) {
        .col-md-9 {
            height: calc(100vh - 56px);
            padding: 15px;
        }

        .response-card {
            padding: 25px;
        }

        .response-icon {
            font-size: 3rem;
        }

        .response-title {
            font-size: 1.5rem;
        }

        .response-message {
            font-size: 1rem;
        }

        .response-actions {
            flex-direction: column;
            align-items: center;
        }

        .response-actions .btn {
            width: 100%;
            max-width: 250px;
        }
    }
</style>
HTML;

// Dynamic content
$content = <<<HTML
<div class="response-container">
    <div class="response-card">
        <div class="response-icon {$type}">
            <i class="fas {$icon}"></i>
        </div>
        
        <h2 class="response-title">{$title}</h2>
        
        <div class="response-message">
            {$message}
        </div>

HTML;

// Add details if they exist.
if (!empty($details)) {
    $content .= <<<HTML
        <div class="response-details">
            <pre>{$details}</pre>
        </div>
HTML;
}

$content .= <<<HTML
        <div class="response-actions">
HTML;

// Back button
if ($showBackButton) {
    $content .= <<<HTML
            <a href="{$backUrl}" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Back
            </a>
HTML;
}

// Primary button (if specified)
if (!empty($primaryButton)) {
    $primaryBtnText = $primaryButton['text'] ?? 'Continue';
    $primaryBtnUrl = $primaryButton['url'] ?? '#';
    $primaryBtnIcon = $primaryButton['icon'] ?? 'fa-arrow-right';

    $content .= <<<HTML
            <a href="{$primaryBtnUrl}" class="btn btn-primary">
                <i class="fas {$primaryBtnIcon}"></i> {$primaryBtnText}
            </a>
HTML;
}

$content .= <<<HTML
        </div>
HTML;

// Redirect counter
if (!empty($redirectUrl)) {
    $redirectSeconds = $redirectTime / 1000;
    $content .= <<<HTML
        <div class="countdown">
            Redirecting in <span class="countdown-number" id="countdown">{$redirectSeconds}</span> seconds...
        </div>
HTML;
}

$content .= <<<HTML
    </div>
</div>
HTML;

if (!empty($redirectUrl)) {

    $inlineScript = "<script>document.addEventListener('DOMContentLoaded', function () {";

    // If menuActive was sent, we activated the menu.
    if (!empty($menuActive)) {
        $inlineScript .= "
            const menuItems = document.querySelectorAll('.menu-item, #navbarMobileMenu .nav-link');
            menuItems.forEach(item => {
                item.classList.remove('active');
                if (item.getAttribute('data-menu') === '{$menuActive}') {
                    item.classList.add('active');
                }
            });
            localStorage.setItem('activeMenu', '{$menuActive}');
        ";
    }

    // Countdown (always included if there is a redirectUrl)
    $inlineScript .= "
        const countdownElement = document.getElementById('countdown');
        let seconds = {$redirectSeconds};

        const countdownInterval = setInterval(function() {
            seconds--;
            countdownElement.textContent = seconds;

            if (seconds <= 0) {
                clearInterval(countdownInterval);
                window.location.href = '{$redirectUrl}';
            }
        }, 1000);

        // Permite pular o redirecionamento
        document.addEventListener('click', function(e) {
            if (e.target.tagName === 'A' && e.target.href) {
                clearInterval(countdownInterval);
            }
        });
    ";

    $inlineScript .= "});</script>";
}

include __DIR__ . '/../layouts/main.php';