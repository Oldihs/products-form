document.addEventListener('DOMContentLoaded', () => {
    const cursor = document.getElementById('custom-cursor');

    // Show cursor after content loads
    cursor.classList.add('show');

    // Update cursor position on mouse move
    document.addEventListener('mousemove', (e) => {
        cursor.style.left = `${e.clientX}px`;
        cursor.style.top = `${e.clientY}px`;
    });

    // Optional: Add subtle cursor movement animation
    document.addEventListener('mouseenter', () => {
        cursor.classList.add('show');
    });

    document.addEventListener('mouseleave', () => {
        cursor.classList.remove('show');
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const cursor = document.getElementById('custom-cursor');
    cursor.classList.add('show');

    let mouseX = 0, mouseY = 0;
    let cursorX = 0, cursorY = 0;
    const speed = 0.1; // Adjust for smoother or snappier cursor

    document.addEventListener('mousemove', (e) => {
        mouseX = e.clientX;
        mouseY = e.clientY;
    });

    function animateCursor() {
        cursorX += (mouseX - cursorX) * speed;
        cursorY += (mouseY - cursorY) * speed;
        cursor.style.left = `${cursorX}px`;
        cursor.style.top = `${cursorY}px`;
        requestAnimationFrame(animateCursor);
    }

    animateCursor();

    // Show/Hide cursor on enter/leave
    document.addEventListener('mouseenter', () => {
        cursor.classList.add('show');
    });

    document.addEventListener('mouseleave', () => {
        cursor.classList.remove('show');
    });
});