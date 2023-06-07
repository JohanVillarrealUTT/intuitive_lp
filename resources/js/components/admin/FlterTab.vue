<template>
    <button @click="$emit('on-click')" :class="filterTabCss">
        <slot></slot>
    </button>
</template>

<script>
import { css } from 'vue-emotion'
import colors from '@/config/admin/AdminColors'

export default {
    data() {
        return {
            filterTabCss: css({
                backgroundColor: 'transparent',
                border: 'none',
                borderBottom: `0.25rem solid transparent`,
                cursor: 'pointer',
                display: 'flex',
                alignItems: 'center',
                fontSize: '1rem',
                outline: 'none',
                padding: '1.75rem 1.25rem',
                textAlign: 'left',
                '&.active': {
                    borderBottomColor: colors.secondary.danger,
                    color: colors.secondary.danger,
                    g: {
                        fill: colors.secondary.danger
                    }
                },
                svg: {
                    marginRight: '0.75rem'
                },
                g: {
                    fill: colors.neutral.GraniteGray
                },
                '&.filter-tab-aceptados': {
                    borderBottomColor: colors.secondary.success,
                    color: colors.secondary.success,
                    g: {
                        fill: colors.secondary.success
                    }
                }
            })
        }
    }
}
</script>
