import colors from '@/config/website/WebsiteColors.js'

export default Object.freeze({
  commonBreakpoints: {
    sm: '720px',
    md: '980px',
    lg: '1280px',
  },
  border: {
    width: '0.063rem',
    style: 'solid',
    color: '#eee'
  },
  nav: {
    bgColor: colors.landing.white,
    paddingAll: '1rem',
    logoMaxWidth: '130px',
    logoFile: '/images/landing-v2/logo.png',
  },
  sections: {
    landingSection: {
      padding: '0rem',
    },
    hero: {
      copyMarginTop: '27.2rem',
      fontBreakPoint: '600px',
      fontSize: '3rem',
      breakPintFontSize: '4rem',
      padding: '1rem 1rem 4rem 1rem',
    },
    halfs: {
      marginBetween: '3rem',
      breakPoint: '1120px'
    },
    videoCard: {
      hashtagFontSize: '1.5rem',
      fontSize: '1.25rem',
      padding: '1rem',
      hashtagFontWeight: '800',
      backgroundImage: '/images/landing-v2/tacoma-red.png',
      backgroundNegativeMargin: '250px',
      responsiveBackgroundNegativeMargin: '250px',
    },
    subscription: {
      formMaxWidth: '900px',
    },
  },
  buttons: {
    secondary: {
      fontWeight: '600',
      fontSize: '1rem',
      padding: '1rem 2.5rem',
    }
  },
  text: {
    h1: {
      fontSize: '80px',
      fontWeight: 400
    },
    h2:{
      fontSize: '48px',
      fontWeight: 800
    },
    h3: {
      fontSize: '24px',
      fontWeight: 400
    },
    th: {
      fontSize: '1rem',
      fontWeight: 500
    },
    p: {
      fontSize: '1rem',
      fontWeight: 400
    },
    label: {
      fontSize: '14px',
      fontWeight: 500
    },
    paginationNumber: {
      fontSize: '14px',
      fontWeight: 400
    },
    button: {
      fontSize: '1rem',
      fontWeight: 400
    },
    input: {
      fontSize: '1rem',
      fontWeight: 400
    }
  },
  transition: 'all 0.2s ease',
  
  dialogueSlide: {
    breakpoint: '600px',
    textBreakpoints: {
      sm: {
        screen: '980px',
        fontSize: '1.5rem',
      },
      md: {
        screen: '1098px',
        fontSize: '1.5rem',
      },
      lg: {
        screen: '1200px',
        fontSize: '1.5rem',
      },
    }
  },
  dialogueModalVideo: {
    padding: '1.25rem',
    mutedText: {
      fontSize: '1rem',
      fontWeight: '400'
    }
  },
  footer: {
    copyRight:{
      h4:{
        fontSize:'2rem',
        fontWeight: 100
      },
      muted:{
        fontSize:'1rem',
        fontWeight: 400
      }
    }
  }

})
