// resources/js/app.js
import "./bootstrap";
import Alpine from "alpinejs";

// Alpine.js
window.Alpine = Alpine;
Alpine.start();

// Global JavaScript functions (tanpa Swiper karena pakai CDN)
window.updateProgress = function (percentage) {
    const progressBar = document.querySelector(".progress-bar");
    if (progressBar) {
        progressBar.style.width = percentage + "%";
        progressBar.setAttribute("aria-valuenow", percentage);
    }
};

// Video player controls
window.initVideoPlayer = function (videoElement) {
    if (!videoElement) return;

    videoElement.addEventListener("loadedmetadata", function () {
        const duration = this.duration;
        const durationDisplay = document.querySelector(".video-duration");
        if (durationDisplay) {
            durationDisplay.textContent = formatTime(duration);
        }
    });

    videoElement.addEventListener("timeupdate", function () {
        const currentTime = this.currentTime;
        const duration = this.duration;
        const percentage = (currentTime / duration) * 100;

        const progressBar = document.querySelector(".video-progress");
        if (progressBar) {
            progressBar.style.width = percentage + "%";
        }

        const currentTimeDisplay = document.querySelector(
            ".video-current-time"
        );
        if (currentTimeDisplay) {
            currentTimeDisplay.textContent = formatTime(currentTime);
        }
    });
};

function formatTime(seconds) {
    const minutes = Math.floor(seconds / 60);
    const remainingSeconds = Math.floor(seconds % 60);
    return `${minutes}:${remainingSeconds.toString().padStart(2, "0")}`;
}

// Setup CSRF token for AJAX requests
const token = document.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
} else {
    console.error("CSRF token not found");
}
