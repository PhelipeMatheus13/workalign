// script.js
$(document).ready(function () {
    console.log('Script.js loaded - initializing menu system');
    
    // Inicializar DataTable se a tabela existir
    if ($('#employees-table').length) {
        $('#employees-table').DataTable();
        console.log('DataTable initialized for employees table');
    }

    // Seleciona itens de ambos os menus
    const menuItems = document.querySelectorAll('.menu-item, #navbarMobileMenu .nav-link');
    console.log('Found menu items: ', menuItems.length);

    function setActive(key) {
        console.log('Setting active menu to: ', key);
        menuItems.forEach(it => it.classList.remove('active'));
        const elements = document.querySelectorAll(`[data-menu="${key}"]`);
        console.log('Found elements for menu: ', elements.length);
        elements.forEach(el => el.classList.add('active'));
    }

    // Determinar a página atual baseada na URL
    function getCurrentPage() {
        const path = window.location.pathname;
        const page = path.split('/').pop();
        console.log('Current page: ', page);
        
        if (page === 'employees.html' || page === 'register_employee.html') return 'employees';
        if (page === 'departments.html' || page === 'register_department.html') return 'departments';
        if (page === 'index.html' || page === '') return 'dashboard';
        return 'dashboard'; // padrão
    }

    const saved = localStorage.getItem('activeMenu');
    const currentPage = getCurrentPage();
    
    console.log('Saved menu from localStorage: ', saved);
    console.log('Current page detected: ', currentPage);
    
    // Prioridade: usar o saved se existir, senão usar currentPage
    const menuToActivate = saved || currentPage;
    console.log('Menu to activate: ', menuToActivate);
    
    setActive(menuToActivate);

    menuItems.forEach(it => {
        it.addEventListener('click', function (e) {
            e.preventDefault();
            const key = this.getAttribute('data-menu');
            console.log('Menu clicked: ', key);
            localStorage.setItem('activeMenu', key);
            setActive(key);
            
            // Fechar menu mobile após clique
            if ($('#navbarMobileMenu').length) {
                $('#navbarMobileMenu').collapse('hide');
            }
            
            // Navegar para a página se não for a mesma
            const href = this.getAttribute('href');
            if (href && href !== '#' && href !== window.location.pathname) {
                window.location.href = href;
            }
        });
    });
});