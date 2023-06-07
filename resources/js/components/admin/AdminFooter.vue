<template>
    <footer :class="footerCss">
        <div class="container">
            &copy; 2019
            <a href="https://atraetalento.com" target="_blank">atraetalento.com</a>
        </div>
    </footer>
</template>

<script>
import { css } from 'vue-emotion'
import colors from '@/config/admin/AdminColors.js'
import vars from '@/config/admin/AdminVariables.js'

export default {
    data: () => ({
        footerCss: css({
            borderTop: `
                ${vars.border.width}
                ${vars.border.style}
                ${vars.border.color}`,
            color: colors.neutral.SpanishGray,
            padding: '2rem 0',
            textAlign: 'center',
            a: {
                color: colors.neutral.SpanishGray
            }
        })
    })
}
</script>