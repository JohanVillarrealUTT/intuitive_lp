<template>
    <modal-window :show-modal="showModal" max-width="600px">
        <modal-head>
            <modal-title>
                {{ isEditing ? 'Editar' : 'Agregar' }} etiqueta
            </modal-title>
        </modal-head>
        <modal-body>
            <modal-data>
                <form @submit.prevent.default>
                    <modal-data-item>
                        <form-field
                            label="Nombre"
                            v-model="name"
                            type="text"
                            name="name"
                            v-validate="'required'"
                            :error="errors.first('name')"
                        ></form-field>
                    </modal-data-item>

                    <modal-data-item>
                        <form-field
                            label="Color"
                            v-model="color"
                            type="color"
                            name="color"
                            v-validate="'required'"
                            :error="errors.first('color')"
                        ></form-field>
                    </modal-data-item>
                    
                    <modal-buttons>
                        <button-link @on-click="onClickCancel" type="button">Cancelar</button-link>
                        <button-primary
                            :disabled="errors.any()"
                            @on-click="onClickSave"
                            type="submit"
                        >Guardar</button-primary>
                    </modal-buttons>
                </form>
            </modal-data>
        </modal-body>
    </modal-window>
</template>

<script>
import ModalWindow from '@/components/admin/ModalWindow.vue'
import styled, { css } from 'vue-emotion'
import vars from '@/config/admin/AdminVariables'
import FormField from '@/components/admin/FormField.vue'
import SelectInput from '@/components/admin/SelectInput.vue'
import ButtonLink from '@/components/admin/ButtonLink.vue'
import ButtonPrimary from '@/components/admin/ButtonPrimary.vue'
import EventService from '@/services/AdminEventService'

const ModalHead = styled('div')`
    border-bottom: ${vars.border.width} ${vars.border.style}
        ${vars.border.color};
    font-size: ${vars.text.h1.fontSize};
    font-weight: ${vars.text.h1.fontWeight};
    height: 120px;
    display: flex;
    align-items: center;
    padding: 0 1.25rem;
`
const ModalTitle = styled('span')`
    padding-left: 0.5rem;
`
const ModalBody = styled('div')`
    display: grid;
    grid-template-columns: 1fr;
    padding: 1.5rem 0 2rem;
`
const ModalData = styled('div')`
    grid-column: 1/2;
    display: grid;
    grid-template-columns: 1fr;
`
const ModalDataItem = styled('div')`
    padding: 1rem 1.25rem;
    .px-0 {
        padding-left: 0;
        padding-right: 0;
    }

    .p0 {
        padding: 0;
    }
`
const ModalButtons = styled(ModalDataItem)`
    text-align: right;

    &.p0 {
        padding: 0;
    }
`


const ModalDobleDataItem = styled(ModalDataItem)`
    display: flex;
    justify-content: space-between;
`

export default {
    components: {
        ButtonLink,
        ButtonPrimary,
        FormField,
        SelectInput,
        ModalBody,
        ModalButtons,
        ModalData,
        ModalDataItem,
        ModalDobleDataItem,
        ModalHead,
        ModalTitle,
        ModalWindow,
    },
    props: ['show-modal', 'isEditing'],
    provide() {
        return { parentValidator: this.$validator };
    },
    data() {
        return {
            id: '',
            name: '',
            color: '',
        }
    },
    created() {
        if (this.isEditing) {
            this.id = this.isEditing.id;
            this.name = this.isEditing.name;
            this.color = this.isEditing.color;
        }
    },
    methods: {
        onClickCancel() {
            this.$parent.$data.showLabelForm = false
            this.$parent.$data.formIsEditing = null
        },
        onClickSave() {
            this.$validator.validate().then(valid => {
                if (!valid) return
            
                const payload = {
                    name: this.name,
                    color: this.color
                }

                let p = this.isEditing
                    ? EventService.updateLabel(this.id, payload)
                    : EventService.postLabel(payload)
                    
                    p
                        .then(response => {
                            this.$parent.$refs.table.refresh();
                            this.$parent.$data.showLabelForm = false;
                        })
                        .catch(error => {
                            alert('Ocurrió un error:', error.response)
                            console.log('Ocurrió un error:', error.response)
                        })
            });
        }
    }
}
</script>