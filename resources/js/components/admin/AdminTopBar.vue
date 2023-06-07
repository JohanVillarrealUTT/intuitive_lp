<template>
    <header :class="headerCss">
        <div class="container">
            <div :class="headerContentCss">
                <slot></slot>
            </div>
        </div>
    </header>
</template>

<script>
import { css } from 'vue-emotion'

export default {
    data: () => ({
        headerCss: css({
            padding: '1rem 0',

            borderBottom: 'solid 1px #eee',
            '.header-logo': {
                height: '40px',
                marginRight: '2rem',
            }
        }),
        headerContentCss: css({
            display: 'flex',
            justifyContent: 'space-between',
            alignItems: 'center',
            '.header-menu': {
                display: 'flex',
                alignItems: 'center',
                a: {
                    margin: '0 1rem 0 0',
                }
            }
        })
    })
}
</script>