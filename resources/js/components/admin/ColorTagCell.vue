<template>
    <color-tag :color="(rowData.label && rowData.label.color) || rowData.color"></color-tag>
</template>

<script>
import ColorTag from '@/components/admin/ColorTag.vue'

export default {
    components: { ColorTag },
    name: 'ColorTagCell',
    props: {
        rowData: {
            type: Object,
            required: true
        },
        rowIndex: {
            type: Number
        }
    }
}
</script>
