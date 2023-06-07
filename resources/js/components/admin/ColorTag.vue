<template>
    <div :class="colorTagCss" :style="{ backgroundColor: color }"></div>
</template>

<script>
import { css } from 'vue-emotion'

export default {
    props: ['color'],
    data() {
        return {
            colorTagCss: css({
                borderRadius: '50%',
                width: '1rem',
                height: '1rem'
            })
        }
    }
}
</script>