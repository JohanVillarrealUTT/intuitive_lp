<template>
    <li :class="commentCss">
        
        <template v-if="commentEdition.isEditing">
            
            <form-field-textarea v-model="commentEdition.comment"></form-field-textarea>
            
            <div style="text-align: right">
                <a href="#" @click.prevent="onClickCancel" style="margin-right: .5rem;">Cancelar</a>

                <button-primary
                    @on-click="onClickSaveComment"
                    :disabled="!commentEdition.comment"
                >Guardar</button-primary>
            </div>

        </template>
        
        <template v-else>
            <div :class="commentBodyCss">{{ comment.comment }}</div>
            <div :class="commentMetaCss">{{ getCommentMeta(userName, comment.created_at) }}</div>
            <div>
                <a href="#" @click.prevent="onClickEditComment">Editar</a>
            </div>
        </template>

    </li>
</template>

<script>
import axios from 'axios'
import { css } from 'vue-emotion'
import vars from '@/config/admin/AdminVariables.js'
import colors from '@/config/admin/AdminColors.js'
import EventService from '@/services/AdminEventService.js'
import FormFieldTextarea from "@/components/admin/FormFieldTextarea.vue";
import ButtonPrimary from "@/components/admin/ButtonPrimary.vue";
import moment from 'moment'

moment.locale('es')

export default {
    props: ['comment'],
    components: {
        ButtonPrimary,
        FormFieldTextarea,
    },
    data() {
        return {
            userName: '',
            commentCss: css({
                marginBottom: '1rem'
            }),
            commentBodyCss: css({
                color: colors.neutral.GraniteGray,
                fontSize: vars.text.input.fontSize,
                fontWeight: vars.text.input.fontWeight,
                wordBreak: 'break-all',
            }),
            commentMetaCss: css({
                color: colors.neutral.SpanishGray,
                fontSize: vars.text.label.fontSize,
                fontWeight: vars.text.label.fontWeight
            }),
            commentMeta: '',
            commentEdition: {
                isEditing: false,
                comment: '',
                user_id: authUserId,
            }
        }
    },
    mounted() {
        this.getUserName(this.comment.user_id)
    },
    methods: {
        getUserName(id) {
            EventService.getUser(id)
                .then(response => {
                    this.userName = response.data.name
                })
                .catch(error => {
                    alert('Ocurrió un error:', error.response)
                    console.log('Ocurrió un error:', error.response)
                })
        },
        getCommentMeta(name, date, fmt = '– MMM D @ HH:mm') {
            const commentDate =
                date == null
                    ? ''
                    : moment(date, 'YYYY-MM-DD HH:mm:ss').format(fmt)
            this.commentMeta = `${name} ${commentDate}`
            return this.commentMeta
        },
        onClickEditComment() {
            this.commentEdition.isEditing = true;
            this.commentEdition.comment = this.comment.comment;
        },
        onClickSaveComment() {
            let payload = {
                ...this.commentEdition,
                // created_at: new Date()
            };

            EventService.putComment(this.comment.id, payload)
                .then(r => {
                    this.comment = r.data.comment;
                    // this.comment.created_at = payload.created_at;
                    this.onClickCancel()
                })
                .catch(this.$parent.$parent.$parent.errorHandler)
        },
        onClickCancel() {
            this.commentEdition.isEditing = false;
            this.commentEdition.comment = '';
        }
    }
}
</script>
