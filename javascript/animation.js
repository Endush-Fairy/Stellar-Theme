document.addEventListener("DOMContentLoaded", function () {
    function addBackgroundAnimation(section) {
        if (section && !section.querySelector(".background-animation")) {
            let backgroundDiv = document.createElement("div");
            backgroundDiv.classList.add("background-animation");

            let elements = [
                { type: "surgical-sign", icon: "fa-briefcase-medical", top: "20%", left: "30%", delay: "0s" },
                { type: "surgical-sign", icon: "fa-briefcase-medical", top: "15%", right: "5%", delay: "0.5s" },
                { type: "surgical-sign", icon: "fa-briefcase-medical", bottom: "40%", left: "0%", delay: "1s" },
                { type: "surgical-sign", icon: "fa-briefcase-medical", bottom: "30%", right: "10%", delay: "1.5s" },
                { type: "surgical-sign", icon: "fa-briefcase-medical", top: "55%", left: "40%", delay: "2s" },
                { type: "surgical-sign", icon: "fa-briefcase-medical", top: "90%", left: "35%", delay: "2s" },
                { type: "pill-shape", icon: "fas fa-microscope", top: "10%", left: "15%", delay: "0s" },
                { type: "pill-shape", icon: "fas fa-microscope", top: "20%", right: "45%", delay: "0.5s" },
                { type: "pill-shape", icon: "fas fa-microscope", bottom: "30%", left: "20%", delay: "1s" },
                { type: "pill-shape", icon: "fas fa-microscope", bottom: "55%", right: "20%", delay: "1.5s" },
                { type: "pill-shape", icon: "fas fa-microscope", top: "90%", right: "15%", delay: "2s" },
                { type: "pill-shape", icon: "fas fa-microscope", bottom: "10%", left: "55%", delay: "2.5s" }
            ];

            elements.forEach(({ type, icon, ...styles }) => {
                let div = document.createElement("div");
                div.classList.add(type);
                div.innerHTML = `<i class="fas ${icon}"></i>`;

                Object.assign(div.style, styles, { animationDelay: styles.delay });
                backgroundDiv.appendChild(div);
            });

            section.appendChild(backgroundDiv);
        }
    }

    document.querySelectorAll(".block, .course-content-item-content").forEach(section => {
        addBackgroundAnimation(section);
    });
});


