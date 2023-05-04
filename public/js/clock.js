function setClock() {
    const date = new Date();
    let hours = date.getHours();
    let minutes = date.getMinutes();
    let seconds = date.getSeconds();

    const hourDeg = (hours / 12) * 360 + (minutes / 60) * 30;
    const minuteDeg = (minutes / 60) * 360 + (seconds / 60) * 6;
    const secondDeg = ((seconds + 15) / 60) * 360 - 90;

    const hourHand = document.querySelector(".hour-hand");
    const minuteHand = document.querySelector(".minute-hand");
    const secondHand = document.querySelector(".second-hand");

    hourHand.style.transform = `rotate(${hourDeg}deg)`;
    minuteHand.style.transform = `rotate(${minuteDeg}deg)`;
    secondHand.style.transform = `rotate(${secondDeg}deg)`;

    const digitalClock = document.querySelector(".digital-clock");
    seconds < 10 ? seconds = "0" + seconds : seconds;
    minutes < 10 ? minutes = "0" + minutes : minutes;
    hours < 10 ? hours = "0" + hours : hours;
    digitalClock.innerHTML = `${hours}:${minutes}:${seconds}`;
}

setInterval(setClock, 1000); // update the clock every second
