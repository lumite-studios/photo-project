const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
	future: {
		defaultLineHeights: true,
		purgeLayersByDefault: true,
		removeDeprecatedGapUtilities: true,
		standardFontWeights: true,
	},

    theme: {
        extend: {
			colors: {
				brand: '#009990',
			},
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
			maxHeight: theme => theme('height'),
			maxWidth: theme => theme('width'),
			minHeight: theme => theme('height'),
			minWidth: theme => theme('width'),
			width: {
				'7xl': '80rem',
			},
        },
    },

    variants: {
        //
    },
};
