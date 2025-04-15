function createCalculator() {
    const calculator = document.createElement('div');
    calculator.className = 'calculator';

    // Create the display
    const display = document.createElement('input');
    display.type = 'text';
    display.id = 'display';
    display.disabled = true;
    calculator.appendChild(display);

    const buttons = [
        'C', '+/-', '%', '/',
        '7', '8', '9', '*',
        '4', '5', '6', '-',
        '1', '2', '3', '+',
        '0', '.', '='
    ];

    const buttonsContainer = document.createElement('div');
    buttonsContainer.className = 'buttons';

    buttons.forEach(button => {
        const btn = document.createElement('button');
        btn.textContent = button;

        if (button === 'C') {
            btn.onclick = clearDisplay;
        } else if (button === '+/-') {
            btn.onclick = toggleSign;
        } else if (button === '=') {
            btn.onclick = calculateResult;
        } else {
            btn.onclick = () => appendToDisplay(button);
        }

        buttonsContainer.appendChild(btn);
    });

    calculator.appendChild(buttonsContainer);
    document.body.appendChild(calculator);
}

function appendToDisplay(value) {
    const display = document.getElementById('display');
    display.value += value;
}

function clearDisplay() {
    const display = document.getElementById('display');
    display.value = '';
}

function toggleSign() {
    const display = document.getElementById('display');
    if (display.value) {
        display.value = (parseFloat(display.value) * -1).toString();
    }
}

function calculateResult() {
    const display = document.getElementById('display');
    try {
        display.value = eval(display.value);
    } catch (error) {
        display.value = 'Error';
    }
}

window.onload = createCalculator;