function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        }

        // Fecha o menu ao clicar fora dele
        document.addEventListener('click', function (event) {
            const sidebar = document.getElementById('sidebar');
            const settingsIcon = document.querySelector('.settings-icone');

            const clickedInsideSidebar = sidebar.contains(event.target);
            const clickedSettingsIcon = settingsIcon.contains(event.target);

            if (!clickedInsideSidebar && !clickedSettingsIcon) {
            sidebar.classList.remove('active');
            }
        });