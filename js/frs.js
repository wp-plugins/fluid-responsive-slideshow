/*
 * Tonjoo Fluid Responsive Slideshow
 * Copyright 2013, Tonjoo
 * Free to use under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 */
(function (jQuery) {

    jQuery.fn.frs = function (options) {

        //Defaults to extend options
        var defaults = {
            'animation': 'horizontal-slide', // horizontal-slide, vertical-slide, fade
            'animationSpeed': 600, // how fast animtions are
            'timer': false, // true or false to have the timer
            'advanceSpeed': 4000, // if timer is enabled, time between transitions 
            'pauseOnHover': true, // if you hover pauses the slider
            'startClockOnMouseOut': false, // if clock should start on MouseOut
            'startClockOnMouseOutAfter': 1000, // how long after MouseOut should the timer start again
            'directionalNav': true, // manual advancing directional navs
            'captions': true, // do you want captions?
            'captionAnimation': 'fade', // fade, slideOpen, none
            'captionAnimationSpeed': 600, // if so how quickly should they animate in
            'bullets': false, // true or false to activate the bullet navigation
            'bulletThumbs': false, // thumbnails for the bullets
            'bulletThumbLocation': '', // location from this file where thumbs will be
            'afterSlideChange': function () {}, // empty function 
            'navigationSmallTreshold': 650,
            'navigationSmall': false,
            'skinClass': 'default',
            'width': 650,
            'height': 350,
            'slideParameter': []
        };


        //Extend those options
        var options = jQuery.extend(defaults, options);

        frs_id = "#" + this.attr("id") + "-slideshow";
       
        return this.each(function () {

            // ==============
            // ! SETUP   
            // ==============

            //Global Variables
            var activeSlide = 0,
                numberSlides = 0,
                frsWidth,
                frsHeight,
                locked,
                caption_position,
                timeout;

            //Initialize
            var slideWrapper = jQuery(this).children('.slide-img-wrapper').addClass('slide-img-wrapper');
            var frs = slideWrapper.wrap('<div class="frs-slideshow-content" />').parent();            
            var frsWrapper = frs.wrap('<div id="' + jQuery(this).attr("id") + '-slideshow" class="frs-wrapper ' + options.skinClass.toLowerCase() + '" />').parent();
            
            //Lock slider before all content loaded
            lock();

            //Initialize and show slider after all content loaded
            jQuery(slideWrapper.children()).imagesLoaded( function() {
                slideWrapper.fadeIn(function(){
                    jQuery(this).css({"display": "block"});
                })

                slideWrapper.children().fadeIn(function(){
                    jQuery(this).css({"display": "block"});
                })
                
                frsWrapper.children('.frs-slideshow-content').fadeIn(function(){
                    jQuery(this).css({"display": "block"});
                })

                frsWrapper.children('.timer').fadeIn(function(){
                    jQuery(this).css({"display": "block"});
                })

                frsWrapper.children('.slider-nav').fadeIn(function(){
                    jQuery(this).css({"display": "block"});
                })

                frsWrapper.children('.frs-bullets-wrapper').fadeIn(function(){
                    jQuery(this).css({"display": "block"});

                    //unlock event in last displayed element
                    unlock();
                })
            })

            frs.css({
                'height': options.height,
                'max-width': options.width
            });

            frsWrapper.parent().css({
                'height': options.height,
                'max-width': options.width
            });


            frs.add(frsWidth)

            //Collect all slides and set slider size of largest image
            var slides = slideWrapper.children('div');

            //count slide
            slides.each(function (index,slide) {

                numberSlides++;
            });

            //Animation locking functions
            function unlock() {
                locked = false;
            }

            function lock() {
                locked = true;
            }

            //If there is only a single slide remove nav, timer and bullets
            if (slides.length == 1) {
                options.directionalNav = false;
                options.timer = false;
                options.bullets = false;
            }

            //Set initial front photo z-index and fades it in
            if(! css3support())
            {
                slides.eq(activeSlide)
                    .css({
                        "z-index": 3,
                        "display": "block",
                        "left": 0
                    })
                    .fadeIn(function () {
                        //brings in all other slides IF css declares a display: none
                        slides.css({
                            "display": "block"
                        })
                    });
            }



            // ====================================
            // ! RESIZE WINDOWS EVENT: RESPONSIVE   
            // ====================================
            
            jQuery(window).bind('resize.frs-slideshow-container', function(event, force) {
                calculateHeightWeight();

                /**
                 * resize elements
                 */
                slides.width(frsWidth);                
                slides.height(frsHeight);
                slides.children('img').width(frsWidth);

                /* resize wrapper */
                frs.css({'height': frsHeight + 'px'});
                frsWrapper.parent().css({'height': frsHeight + 'px'});

                if(css3support())
                {
                    if(options.animation == "horizontal-slide")
                    {
                        slideWrapper.css({
                            'width': options.width * numberSlides + 'px'
                        });

                        var slide_action = frsWidth * activeSlide < numberSlides * frsWidth ? '-' + frsWidth * activeSlide : 0 ;

                        /** Stabilize slide position */
                        var properties = {};
                        properties[ '-' + vendorPrefix + '-transform' ] = 'translate3d('+ slide_action +'px, 0, 0)';

                        slides.parent().css(properties);
                    }
                    else if(options.animation == "vertical-slide")
                    {
                        slideWrapper.css({
                            'height': options.height * numberSlides + 'px'
                        });

                        var slide_action = frsHeight * activeSlide < numberSlides * frsHeight ? '-' + frsHeight * activeSlide : 0 ;

                        /** Stabilize slide position */
                        var properties = {};
                        properties[ '-' + vendorPrefix + '-transform' ] = 'translate3d(0, '+ slide_action +'px, 0)';

                        slides.parent().css(properties);
                    }
                }
            });

            jQuery(window).trigger('resize.frs-slideshow-container', true);



            // ====================
            // ! CALCULATE SIZE   
            // ====================
            function calculateHeightWeight() 
            {
                frsWidth = frs.outerWidth();

                var minus_resize = options.width - frsWidth;
                var percent_minus = (minus_resize / options.width) * 100;
                frsHeight = options.height - (options.height * percent_minus / 100);
            }



            // ========================
            // ! CHECK AND APPLY CSS 3
            // ========================
            var vendorPrefix;

            function css3support() {
                var element = document.createElement('div'),
                    props = [ 'perspectiveProperty', 'WebkitPerspective', 'MozPerspective', 'OPerspective', 'msPerspective' ];
                for ( var i in props ) {
                    if ( typeof element.style[ props[ i ] ] !== 'undefined' ) {
                        vendorPrefix = props[i].replace('Perspective', '').toLowerCase();
                        return true;
                    }
                }

                return false;
            };

            if(css3support())
            {
                if(options.animation == "horizontal-slide")
                {
                    calculateHeightWeight();

                    slides.parent().css({"width": frsWidth * numberSlides + "px", "height": frsHeight + "px"});

                    slides.css({
                        "position": "relative",
                        "float": "left",
                        "display": "block",
                        "width": frsWidth + "px",
                        "height": + "100%"
                    });
                }
                else if(options.animation == "vertical-slide")
                {
                    calculateHeightWeight();

                    slides.parent().css({"width": frsWidth + "px", "height": frsHeight * numberSlides + "px"});

                    slides.css({
                        "position": "relative",
                        "display": "block",
                        "width": frsWidth + "px",
                        "height": frsHeight + "px"
                    });
                }
                else if(options.animation == "fade")
                {
                    calculateHeightWeight();

                    slides.parent().css({"width": frsWidth + "px", "height": frsHeight + "px"});

                    slides.css({
                        "z-index": 1,
                        "width": frsWidth + "px",
                        "height": frsHeight + "px"
                    });

                    slides.eq(activeSlide).css({"z-index": 3});
                }
            }



            // ==============
            // ! TIMER   
            // ==============
            date = new Date();
            milliseconds = date.getTime();
            start_seconds = milliseconds / 1000;


            function log_time() {
                date = new Date();
                milliseconds = date.getTime();
                seconds = milliseconds / 1000;
                seconds = seconds - start_seconds;         
            }


            //Timer Execution
            function startClock() {
                if (!options.timer || options.timer == 'false') {
                    return false;
                    //if timer is hidden, don't need to do crazy calculations
                } else if (timer.is(':hidden')) {
                    timerRunning = true;
                    clock = setInterval(function (e) {

                        shift("next");

                    }, options.advanceSpeed);
                    //if timer is visible and working, let's do some math
                } else {
                    timerRunning = true;
                    pause.removeClass('active')
                    clock = setInterval(function (e) {

                        var degreeCSS = "rotate(" + degrees + "deg)"
                        rotator.css({
                            "-webkit-transform": degreeCSS,
                            "-ms-transform": degreeCSS,
                            "-moz-transform": degreeCSS,
                            "-o-transform": degreeCSS
                        });
                        degrees += 1
                        if (degrees >= 180) {

                            mask.addClass('move')
                            rotator.addClass('move')
                            mask_turn.css("display", "block")


                        }
                        if (degrees >= 360) {

                            degrees = 0;
                            mask.removeClass('move')
                            rotator.removeClass('move')
                            mask_turn.css("display", "none")

                            shift("next");
                        }
                    }, options.advanceSpeed / 360);
                }
            }

            function stopClock() {
                if (!options.timer || options.timer == 'false') {
                    return false;
                } else {
                    timerRunning = false;
                    clearInterval(clock);
                    pause.addClass('active');
                }
            }



            //Timer Setup
            if (options.timer) {
                var timerHTML = '<div class="timer"><span class="mask"><span class="rotator"></span></span><span class="mask-turn"></span><span class="pause"></span></div>'
                frsWrapper.append(timerHTML);
                var timer = frsWrapper.children('div.timer'),
                    timerRunning;
                if (timer.length != 0) {
                    var rotator = jQuery(frs_id + ' div.timer span.rotator'),
                        mask = jQuery(frs_id + ' div.timer span.mask'),
                        mask_turn = jQuery(frs_id + ' div.timer span.mask-turn'),
                        pause = jQuery(frs_id + ' div.timer span.pause'),
                        degrees = 0,
                        clock;
                    startClock();
                    timer.click(function () {
                        if (!timerRunning) {
                            startClock();
                        } else {
                            stopClock();
                        }
                    });
                    if (options.startClockOnMouseOut) {
                        var outTimer;
                        frsWrapper.mouseleave(function () {

                            outTimer = setTimeout(function () {
                                if (!timerRunning) {
                                    startClock();
                                }
                            }, options.startClockOnMouseOutAfter)
                        })
                        frsWrapper.mouseenter(function () {
                            clearTimeout(outTimer);
                        })
                    }
                }
            }

            //Pause Timer on hover
            if (options.pauseOnHover) {
                frsWrapper.mouseenter(function () {

                    stopClock();
                });
            }



            // ==================
            // ! DIRECTIONAL NAV   
            // ==================

            //DirectionalNav { rightButton --> shift("next"), leftButton --> shift("prev");
            if (options.directionalNav) {
                if (options.directionalNav == "false") {
                    return false;
                }
                var directionalNavHTML = '<div class="slider-nav ' + caption_position + '"><span class="right">›</span><span class="left">‹</span></div>';
                frsWrapper.append(directionalNavHTML);
                var leftBtn = frsWrapper.children('div.slider-nav').children('span.left'),
                    rightBtn = frsWrapper.children('div.slider-nav').children('span.right');
                leftBtn.click(function () {
                    stopClock();
                    shift("prev");
                });
                rightBtn.click(function () {
                    stopClock();
                    shift("next")
                });
            }


            if (options.navigationSmall) {

                jQuery(window).resize(function () {
                    if (jQuery(window).width() < options.navigationSmallTreshold) {
                        frs.siblings("div.slider-nav").addClass('small')
                    } else {
                        frs.siblings("div.slider-nav").removeClass('small')
                    }
                });

                if (frs.width() < options.navigationSmallTreshold) {
                    frs.siblings("div.slider-nav").addClass('small')
                }
            }



            // ==================
            // ! BULLET NAV   
            // ==================

            //Bullet Nav Setup
            if (options.bullets) {

                var bulletHTML = '<ul class="frs-bullets"></ul>';
                var bulletHTMLWrapper = "<div class='frs-bullet-wrapper'></div>";
                frsWrapper.append(bulletHTML);

                var bullets = frsWrapper.children('ul.frs-bullets');
                for (i = 0; i < numberSlides; i++) {
                    var liMarkup = jQuery('<li class="frs-slideshow-nav-bullets"></li>'); // If you want default numbering, add: (i + 1)
                    if (options.bulletThumbs) {
                        var thumbName = slides.eq(i).data('thumb');
                        if (thumbName) {
                            var liMarkup = jQuery('<li class="has-thumb">' + i + '</li>')
                            liMarkup.css({
                                "background": "url(" + options.bulletThumbLocation + thumbName + ") no-repeat"
                            });
                        }
                    }
                    frsWrapper.children('ul.frs-bullets').append(liMarkup);
                    liMarkup.data('index', i);
                    liMarkup.click(function () {
                        stopClock();
                        shift(jQuery(this).data('index'));
                    });
                }
               
                bullets.wrap("<div class='frs-bullets-wrapper " + caption_position + "' />")
                setActiveBullet();
            }

            //Bullet Nav Execution
            function setActiveBullet() {
                if (!options.bullets) {
                    return false;
                } else {
                    bullets.children('li').removeClass('active').eq(activeSlide).addClass('active');
                }
            }


            // ====================
            // ! CAPTION POSITION   
            // ====================
            function set_caption_position()
            {
                caption_position = slides.eq(activeSlide).find('div.frs-caption').attr('class').replace('frs-caption ','');

                //set active caption position to bullet and navigation
                frsWrapper.find('div.frs-bullets-wrapper').attr('class', 'frs-bullets-wrapper ' + caption_position);
                frsWrapper.find('div.slider-nav').attr('class', 'slider-nav ' + caption_position);
            }


            // ====================
            // ! SHIFT ANIMATIONS   
            // ====================
            function shift(direction) {

                //remember previous activeSlide
                var prevActiveSlide = activeSlide,
                    slideDirection = direction;
                //exit function if bullet clicked is same as the current image
                if (prevActiveSlide == slideDirection) {
                    return false;
                }
                //reset Z & Unlock
                function resetAndUnlock() {
                    slides
                        .eq(prevActiveSlide)
                        .css({
                            "z-index": 1
                        });
                    unlock();
                    options.afterSlideChange.call(this);                    
                }

                //CSS3 reset Z & Unlock
                function css3ResetAndUnlock() {
                    unlock();
                    options.afterSlideChange.call(this);                    
                }

                if (slides.length == "1") {
                    return false;
                }
                if (!locked) {
                    lock();
                    //deduce the proper activeImage
                    if (direction == "next") {
                        activeSlide++
                        if (activeSlide == numberSlides) {
                            activeSlide = 0;
                        }
                    } else if (direction == "prev") {
                        activeSlide--
                        if (activeSlide < 0) {
                            activeSlide = numberSlides - 1;
                        }
                    } else {
                        activeSlide = direction;
                        if (prevActiveSlide < activeSlide) {
                            slideDirection = "next";
                        } else if (prevActiveSlide > activeSlide) {
                            slideDirection = "prev"
                        }
                    }
                    //set to correct bullet
                    setActiveBullet();

                    //set previous slide z-index to one below what new activeSlide will be
                    if(! css3support())
                    {
                        slides
                            .eq(prevActiveSlide)
                            .css({
                                "z-index": 2
                            });
                    }

                    
                    calculateHeightWeight()

                    if(options.heightResize==true){

                    jQuery(slides).parent('.frs-slideshow-content').animate(
                        {'height':frsHeight},
                        options.animationSpeed)
                    }

                    
                    /**
                     * Horizontal Slide
                     */
                    if (options.animation == "horizontal-slide") 
                    {
                        calculateHeightWeight();

                        var slide_action = frsWidth * activeSlide < numberSlides * frsWidth ? '-' + frsWidth * activeSlide : 0 ;

                        if (slideDirection == "next") 
                        {
                            if(css3support())
                            {
                                /** Get the properties to transition */
                                var properties = {};
                                properties[ '-' + vendorPrefix + '-transition-duration' ] = options.animationSpeed + 'ms';
                                properties[ '-' + vendorPrefix + '-transform' ] = 'translate3d('+ slide_action +'px, 0, 0)';

                                /** Do the CSS3 transition */
                                slides.parent().css(properties);
                                css3ResetAndUnlock();
                            }
                            else
                            {
                                slides
                                    .eq(activeSlide)
                                    .css({
                                        "left": frsWidth,
                                        "z-index": 3
                                    })
                                    .animate({
                                        "left": 0

                                    }, options.animationSpeed, resetAndUnlock);
                                slides
                                    .eq(prevActiveSlide)
                                    .animate({
                                        "left": -frsWidth
                                    }, options.animationSpeed);
                            }                                                        
                        }

                        if (slideDirection == "prev")
                        {
                            if(css3support())
                            {
                                /** Get the properties to transition */
                                var properties = {};
                                properties[ '-' + vendorPrefix + '-transition-duration' ] = options.animationSpeed + 'ms';
                                properties[ '-' + vendorPrefix + '-transform' ] = 'translate3d('+ slide_action +'px, 0, 0)';

                                /** Do the CSS3 transition */
                                slides.parent().css(properties);
                                css3ResetAndUnlock();
                            }
                            else
                            {
                                slides
                                    .eq(activeSlide)
                                    .css({
                                        "left": -frsWidth,
                                        "z-index": 3
                                    })
                                    .animate({
                                        "left": 0
                                    }, options.animationSpeed, resetAndUnlock);
                                slides                            
                                    .eq(prevActiveSlide)
                                    .animate({
                                        "left": frsWidth
                                    }, options.animationSpeed);
                            }
                            
                        }
                    }

                    /**
                     * Vertical Slide
                     */
                    if (options.animation == "vertical-slide") 
                    {
                        calculateHeightWeight()

                        var slide_action = frsHeight * activeSlide < numberSlides * frsHeight ? '-' + frsHeight * activeSlide : 0 ;

                        if (slideDirection == "prev") {
                            if(css3support())
                            {
                                /** Get the properties to transition */
                                var properties = {};
                                properties[ '-' + vendorPrefix + '-transition-duration' ] = options.animationSpeed + 'ms';
                                properties[ '-' + vendorPrefix + '-transform' ] = 'translate3d(0, '+ slide_action +'px, 0)';

                                /** Do the CSS3 transition */
                                slides.parent().css(properties);
                                css3ResetAndUnlock();
                            }
                            else
                            {
                                slides
                                    .eq(activeSlide)
                                    .css({
                                        "top": frsHeight,
                                        "z-index": 3
                                    })
                                    .animate({
                                        "top": 0
                                    }, options.animationSpeed, resetAndUnlock);
                            }
                        }
                        if (slideDirection == "next") {
                            if(css3support())
                            {
                                /** Get the properties to transition */
                                var properties = {};
                                properties[ '-' + vendorPrefix + '-transition-duration' ] = options.animationSpeed + 'ms';
                                properties[ '-' + vendorPrefix + '-transform' ] = 'translate3d(0, '+ slide_action +'px, 0)';

                                /** Do the CSS3 transition */
                                slides.parent().css(properties);
                                css3ResetAndUnlock();
                            }
                            else
                            {
                                slides
                                    .eq(activeSlide)
                                    .css({
                                        "top": -frsHeight,
                                        "z-index": 3
                                    })
                                    .animate({
                                        "top": 0
                                    }, options.animationSpeed, resetAndUnlock);
                            }
                        }
                    }

                    /**
                     * Fade
                     */
                    if (options.animation == "fade") 
                    {
                        if(css3support())
                        {                            
                            slides.eq(activeSlide).css({'z-index': 2});

                            /** Get the properties to transition */
                            var properties = {};
                            properties[ 'opacity' ] = 0;
                            properties[ '-' + vendorPrefix + '-transition' ] = 'all ' + options.animationSpeed + 'ms ease';

                            slides.eq(prevActiveSlide).css(properties);

                            clearTimeout(timeout);
                            timeout = setTimeout(function() {
                                slides.eq(activeSlide).css({'z-index': 3});

                                /** Get the properties to transition */
                                var properties = {};
                                properties[ 'opacity' ] = 1;
                                properties[ 'z-index' ] = 1;
                                properties[ '-' + vendorPrefix + '-transition' ] = '';
                                
                                slides.eq(prevActiveSlide).css(properties);
                            }, options.animationSpeed - (options.animationSpeed * 20 / 100));                            

                            css3ResetAndUnlock();
                        }
                        else
                        {
                            slides
                                .eq(activeSlide)
                                .css({
                                    "opacity": 0,
                                    "z-index": 3
                                })
                                .animate({
                                    "opacity": 1,
                                }, options.animationSpeed, resetAndUnlock);
                        }
                    }

                    set_caption_position();
                } //lock                                
            } //frs function

            set_caption_position();

        }); //each call
    } //frs plugin call

})(jQuery);