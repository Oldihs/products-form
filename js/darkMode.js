// js/darkMode.js

document.addEventListener('DOMContentLoaded', () => {
    const toggleButton = document.getElementById('darkModeToggle');
    const sunIcon = document.getElementById('sunIcon');
    const moonIcon = document.getElementById('moonIcon');
    const htmlElement = document.documentElement;

    // Function to enable dark mode
    const enableDarkMode = () => {
        htmlElement.classList.add('dark');
        sunIcon.classList.add('hidden');
        moonIcon.classList.remove('hidden');
        localStorage.setItem('theme', 'dark');
    };

    // Function to disable dark mode
    const disableDarkMode = () => {
        htmlElement.classList.remove('dark');
        sunIcon.classList.remove('hidden');
        moonIcon.classList.add('hidden');
        localStorage.setItem('theme', 'light');
    };

    // Initialize theme based on localStorage or system preference
    const initTheme = () => {
        const storedTheme = localStorage.getItem('theme');
        if (storedTheme === 'dark') {
            enableDarkMode();
        } else if (storedTheme === 'light') {
            disableDarkMode();
        } else {
            // If no preference, check system preference
            if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                enableDarkMode();
            } else {
                disableDarkMode();
            }
        }
    };

    // Toggle theme on button click
    toggleButton.addEventListener('click', () => {
        if (htmlElement.classList.contains('dark')) {
            disableDarkMode();
        } else {
            enableDarkMode();
        }
    });

    // Initialize the theme when the page loads
    initTheme();
});
