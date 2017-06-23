(function() {
    var menu = document.getElementsByClassName("burger-menu")[0];
    var sideMenu = document.getElementsByClassName("side-menu")[0];
    var clicked = false;

    menu.onclick = function() {
        if (!clicked) {
            TweenMax.to(".bar-mid", 0.5, { x: 100, ease: Power4.easeOut })
            TweenMax.to(".bar-top", 0.5, { rotation: "+=45", y: 11, ease: Power4.easeOut })
            TweenMax.to(".bar-bottom", 0.5, { rotation: "-=45", y: -11, ease: Power4.easeOut })
            TweenMax.to(".side-menu", 1, { x: -300, ease: Power4.easeOut });
            clicked = true;
        } else {
            TweenMax.to(".bar-mid", 0.5, { x: 0, ease: Power4.easeOut })
            TweenMax.to(".bar-top", 0.5, { rotation: 0, y: 0, ease: Power4.easeOut })
            TweenMax.to(".bar-bottom", 0.5, { rotation: 0, y: 0, ease: Power4.easeOut });
            TweenMax.to(".side-menu", 1, { x: 300, ease: Power4.easeOut });
            clicked = false;
        };
    };

})();

(function() {
    var user = document.getElementsByClassName("user")[0];
    var clicked = false;
    var divHeight = document.getElementsByClassName("user_dropdown")[0].offsetHeight;
    var user_dropdown = document.getElementsByClassName("user_dropdown")[0];

    if (divHeight > 75) {
        var moveAmount = divHeight - 75;
        user_dropdown.style.top = -moveAmount + "px";
        user.onclick = function() {
            if (!clicked) {
                TweenMax.to(".user_dropdown", 0.5, { y: divHeight, ease: Power4.easeOut });
                clicked = true;
            } else {
                TweenMax.to(".user_dropdown", 0.5, { y: -moveAmount, ease: Power4.easeOut });
                clicked = false;
            }
        }
    } else {
        var moveAmount = 75 - divHeight;
        user_dropdown.style.top = moveAmount + "px";
        user.onclick = function() {
            if (!clicked) {
                TweenMax.to(".user_dropdown", 0.5, { y: divHeight, ease: Power4.easeOut });
                clicked = true;
            } else {
                TweenMax.to(".user_dropdown", 0.5, { y: -moveAmount, ease: Power4.easeOut });
                clicked = false;
            }
        }
    }

})();

(function() {
    var search_icon = document.getElementsByClassName("search")[0];
    var clicked = false;
    search_icon.onclick = function() {
        if (!clicked) {
            TweenMax.to(".search_bar_main input", 0.750, { css: { right: "0px" }, ease: Power4.easeOut });
            TweenMax.to(".nav-link", 0.750, { opacity: 0, ease: Power4.easeOut });
            clicked = true;
        } else {
            TweenMax.to(".search_bar_main input", 0.750, { css: { right: "-100%" }, ease: Power4.easeOut });
            TweenMax.to(".nav-link", 0.750, { opacity: 1, ease: Power4.easeOut });
            clicked = false;
        }
    }

})();