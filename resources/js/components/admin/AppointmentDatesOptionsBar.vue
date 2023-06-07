<template>
    <options-bar>
        <options-bar-item>
        </options-bar-item>
        <options-bar-item>
            <a @click.prevent="onCreateDate" href="#">Crear fecha</a>
        </options-bar-item>
    </options-bar>
</template>

<script>
import styled from 'vue-emotion'
import colors from '@/config/admin/AdminColors'
import vars from '@/config/admin/AdminVariables'
import {
    OptionsBar,
    OptionsBarItem,
    ColorTagTotal,
} from './OptionsBar.vue';
import ButtonLink from '@/components/admin/ButtonLink.vue'
import axios from 'axios'
import EventService from '@/services/AdminEventService.js'
import { EventBus } from "@/event-bus.js";

export default {
    components: {
        OptionsBar,
        OptionsBarItem,
        ButtonLink
    },
    props: ['color-tags-totals'],
    data() {
        return {
        }
    },
    mounted() {
    },
    methods: {
        onCreateDate() {
            EventBus.$emit('create-appointment-date')
        }
    }
}
</script>