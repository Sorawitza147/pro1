const text = "Country";

function typeWriter(text, i, fnCallback) {
    if (i < text.length) {
        document.querySelector('.animated-text').innerHTML = text.substring(0, i + 1);
        setTimeout(function () {
            typeWriter(text, i + 1, fnCallback)
        }, 100);
    } else if (typeof fnCallback === 'function') {
        setTimeout(fnCallback, 700);
    }
}

function startTextAnimation(i) {
    if (typeof text === 'string') {
        typeWriter(text, 0, function () {
            startTextAnimation(i);
        });
    }
}

// Start the animation
startTextAnimation(0);
