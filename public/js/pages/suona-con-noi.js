const descriptionField = document.querySelector('[data-character-count]');
const output = document.querySelector('[data-character-output]');

if (descriptionField && output) {
    const renderCount = () => {
        output.textContent = `${descriptionField.value.trim().length} caratteri`;
    };

    renderCount();
    descriptionField.addEventListener('input', renderCount);
}
