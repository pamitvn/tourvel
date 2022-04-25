module.exports = {
   content: [
      './resources/views/**/*.blade.php',
      './resources/js/**/*.js',
   ],
   theme: {
      extend: {
         backgroundImage: {
            'hero-contact': "linear-gradient(to right bottom, rgba(43, 108, 176, 0.8), rgba(43, 108, 176, 0.8)), url(/images/contact-banner-image.jpg)",
            'hero-news': "linear-gradient(to right bottom, rgba(43, 108, 176, 0.8), rgba(43, 108, 176, 0.8)), url(/images/news-banner.jpg)",
         },
      },
   },
   corePlugins: {
      aspectRatio: false,
   },
   plugins: [
      require('@tailwindcss/aspect-ratio'),
      require('@tailwindcss/forms')({
         strategy: 'class'
      }),
   ],
};
