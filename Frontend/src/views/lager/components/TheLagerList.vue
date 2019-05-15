<template>
    <div class="list">
        <ListRow v-for="(itm, idx) of items" :key="'list-lager' + idx" :items="itm">
            <button v-if="deleteButtonShown" class="delete" @click="del(itm)">
                <TrashIcon></TrashIcon>
            </button>
        </ListRow>
    </div>
</template>

<script>
import ListRow from '@/components/ListRow.vue'
import TrashIcon from '@/assets/icons/trash.svg'

export default {
    components: {
        ListRow,
        TrashIcon
    },
    props: {
        items: {
            type: Array,
            required: true
        },
        deleteButtonShown: {
            type: Boolean,
            default: false
        }
    },
    methods: {
        async del(itm) {
            /**
             * Sicherheitsabfrage 'wirklich löschen?'
             */
            const { value } = await this.$swal({
                text: `Möchten Sie das Lager '${itm[1].key}' wirklich löschen?`,
                showCancelButton: true
            })

            if (value) {
                /**
                 * Lager löschen
                 */
                const res = await this.$http.post('/index.php', {
                    action: 'deleteLager',
                    id: itm[0].key
                })

                /**
                 * Wenn anlegen erfolgreich
                 */
                const { data } = res
                if (data && data.success) {
                    /**
                     * Lädt bei Erfolg die Liste neu
                     */
                    this.$store.dispatch('loadLager')
                } else {
                    await this.$swal({
                        text: res.data.msg,
                        type: 'error'
                    })
                }
            }
        }
    }
}
</script>

<style src="@/assets/scss/components/List.scss" lang="scss" scoped></style>
