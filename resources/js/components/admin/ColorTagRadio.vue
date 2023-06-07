<template>
    <color-tag-container>
        <color-tag-radio
            @change="onClickRadio"
            v-bind="$attrs"
            type="radio"
            :checked="checked"
            :id="id"
            :name="name"
        ></color-tag-radio>
        <color-tag-label
            :for="id"
            :class="labelBackground">
            <slot></slot>
        </color-tag-label>
    </color-tag-container>
</template>

<script>
import styled, { css, injectGlobal } from 'vue-emotion'
import colors from '@/config/admin/AdminColors.js'

let bgColors = ''
Object.keys(colors.tags).forEach(key => {
    bgColors += `
    [for*='tag-${key}']:before {
      background-color: ${colors.tags[key]};
    }
  `
})

injectGlobal`
  ${bgColors}
`

const ColorTagContainer = styled('div')`
    display: inline-flex;
    align-items: center;

    &:not(:last-child) {
        margin-right: 0.5rem;
    }
`
const ColorTagRadio = styled('input')`
    opacity: 0;
    position: absolute;
    z-index: -1;

    &:checked + label {
        &:before {
            border: 0.125rem solid rgba(0, 0, 0, 0.2);
        }
    }
`
const ColorTagLabel = styled('label')`
    display: inline-flex;
    align-items: center;
    cursor: pointer;

    &:before {
        content: '';
        border-radius: 50%;
        display: inline-block;
        width: 1rem;
        height: 1rem;
    }

    &:hover {
        &:before {
            border: 0.125rem solid rgba(0, 0, 0, 0.2);
        }
    }

    span {
        display: inline-block;
        padding: 0 0.5rem;
    }
`

export default {
    inheritAttrs: false,
    components: {
        ColorTagContainer,
        ColorTagRadio,
        ColorTagLabel
    },
    props: ['checked', 'value', 'id', 'name', 'data-id', 'color'],
    data() {
        return {
            labelBackground: css({
                ":before": {
                    backgroundColor: this.color
                }
            })
        }
    },
    methods: {
        onClickRadio() {
            const newData = {
                id: this.dataId,
                color_tag: this.value
            }
            this.$emit('selected-color-tag', newData)
        }
    }
}
</script>