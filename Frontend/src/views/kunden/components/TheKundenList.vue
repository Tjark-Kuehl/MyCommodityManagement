<template>
    <div class="list">
        <ListRow v-for="(itm, idx) of items" :key="'list-kunde' + idx" :items="itm">
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
                text: `Möchten Sie den Kunden '${itm[2].key} ${itm[1].key}' wirklich löschen?`,
                showCancelButton: true
            })

            if (value) {
                /**
                 * Artikel löschen
                 */
                const res = await this.$http.post('/index.php', {
                    action: 'deleteKunden',
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
                    this.$store.dispatch('loadKunden')
                } else {
                    console.error(res)
                }
            }
        }
    }
}
</script>

<style src="@/assets/scss/components/List.scss" lang="scss" scoped></style>
