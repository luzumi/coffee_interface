<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<div class="progress-section">
    <img class="waiting-icon" src="{{ asset('storage/media/waitingIcon.svg') }}" alt="Dein SVG-Bild" />

    <div class="svg-container">
        <svg class="overlay-svg" viewBox="0 0 900 1000" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <clipPath id="clip-path">
                    <rect id="clip-rect" x="10" y="100%" width="100%" height="0%"></rect>
                </clipPath>
            </defs>
            <path id="green-path" class="green-path" clip-path="url(#clip-path)"
                  d="m 519.85328,819.04475 c -28.06671,-1.05173 -56.81306,-7.27616 -83.01276,-20.74692 -56.93305,-36.9863 -76.05909,-69.17077 -91.69788,-130.71612 -16.17022,-65.10339 -12.4962,-108.59404 -12.30068,-176.1016 -0.44286,-74.15435 1.22351,-135.38835 0.66927,-209.54243 13.37531,6.68804 35.14589,3.74348 53.59173,5.0091 57.42923,1.49072 325.51842,11.28704 326.50643,-14.44447 -1.13408,21.54217 0.0323,316.7088 -0.8999,388.15509 3.08078,129.53879 -135.47056,162.56808 -190.986,160.59758 z"></path>
        </svg>
    </div>
</div>


</body>
<script>
    window.onload = function() {
        const clipRect = document.getElementById('clip-rect');
        const duration = 2000; // Dauer der Animation in Millisekunden

        function updateHeight() {
            const elapsedTime = Date.now() - startTime;
            const progress = elapsedTime / duration;

            clipRect.setAttribute('y', 100 - progress * 100 + '%');
            clipRect.setAttribute('height', progress * 100 + '%');

            if (progress < 1) {
                requestAnimationFrame(updateHeight);
            }
        }

        const startTime = Date.now();
        updateHeight();
    };
</script>


</html>
