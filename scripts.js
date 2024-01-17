;(function( $, document ) {
  'use strict';

  const testimonials = {

    slideIndex: 0,
    slides: [],

    init: function() {
      this.cacheDom();
      this.showSlides(this.slideIndex);
      this.listener();
    },

    cacheDom: function() {
      this.$el        = $('.site-reviews-carousel-container');
      this.$slides    = this.$el.find('.testimonial-slide');
      this.$dots      = this.$el.find('.testimonial-dot');
      this.$nextSlide = this.$el.find('.testimonial-slideshow-container a.next');
      this.$prevSlide = this.$el.find('.testimonial-slideshow-container a.prev');
    },

    listener: function() {
      this.$prevSlide.on('click', this.prevSlide.bind(this));
      this.$nextSlide.on('click', this.nextSlide.bind(this));
    },

    showSlides: function( n ) {

      //Reset Slideshow Loop
      if ( n > this.$slides.length - 1 ) {
        this.slideIndex = 0;
      }

      //Reverse slideshow direction
      if ( Math.sign(n) < 0 ) {
        this.slideIndex = this.$slides.length - 1;
      }

      //Hide all slides
      for ( let i = 0; i < this.$slides.length; i++ ) {
        this.$slides[i].style.display = "none";
      }

      if ( this.$slides[this.slideIndex] ) {
        this.$slides[this.slideIndex].style.display = "block";
      }
    },

    nextSlide: function() {
      this.showSlides(this.slideIndex++);
    },

    prevSlide: function() {
      this.showSlides(this.slideIndex--);
    },

    autoStart: function() {
      setInterval(function(){
        testimonials.$nextSlide.trigger('click');
      }, 6000);
    },
  };

  $(document).ready(function(){
    testimonials.init();
  });

})(jQuery, document);