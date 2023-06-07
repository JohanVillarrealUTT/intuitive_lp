<script>
	import { css } from 'vue-emotion'
	import colors from '@/config/website/WebsiteColors.js'
	import variables from '@/config/website/WebsiteVariables.js'

	export const InputStyle = css({
    	background: 'transparent',
        boxSizing: 'border-box',
        border: 'none',
        borderBottom: `1px solid ${colors.brand.sec}`,
        color: `${colors.brand.dark}`,
        // fontWeight: 600,
        fontSize: '1rem',
        padding: '.5rem 1rem .5rem 0',
        width: '100%',
        borderRadius: '0px',
        outline: 'none',
        "&:focus": {
	    	// background: `${colors.general.lightGrey}`,
            // border: `1px solid ${colors.brand.mid}`,
        },
        "&[type=date]": {
            height: '35px',
        }
    })

	export default {}
</script>