<template>
    <div class="list">
        <ListRow v-for="(itm, idx) of items" :key="'list-auftrag' + idx" :items="itm">
            <button v-if="downloadButtonShown" class="action" @click="download(itm)">
                <DownloadIcon></DownloadIcon>
            </button>
            <button v-if="deleteButtonShown" class="action" @click="del(itm)">
                <TrashIcon></TrashIcon>
            </button>
        </ListRow>
    </div>
</template>

<script>
import ListRow from '@/components/ListRow.vue'
import TrashIcon from '@/assets/icons/trash.svg'
import DownloadIcon from '@/assets/icons/download.svg'

export default {
    components: {
        ListRow,
        TrashIcon,
        DownloadIcon
    },
    props: {
        items: {
            type: Array,
            required: true
        },
        deleteButtonShown: {
            type: Boolean,
            default: false
        },
        downloadButtonShown: {
            type: Boolean,
            default: false
        }
    },
    methods: {
        async download(itm) {
            const link = document.createElement('a')
            link.href = `${process.env.VUE_APP_API_URL}/?task=download_invoice&id=${
                itm[0].rechnung.split('.')[0]
            }`
            link.setAttribute('download', 'file.pdf')
            document.body.appendChild(link)
            link.click()
        },
        async del(itm) {
            /**
             * Sicherheitsabfrage 'wirklich löschen?'
             */
            const { value } = await this.$swal({
                text: `Möchten Sie den Auftrag '${itm[1].key}' wirklich löschen?`,
                showCancelButton: true
            })

            if (value) {
                /**
                 * Artikel löschen
                 */
                const res = await this.$http.post('/index.php', {
                    action: 'deleteAuftrag',
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
                    this.$store.dispatch('loadAuftraege')
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
