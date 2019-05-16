<template>
    <main>
        <template v-if="getAuftraegeNichtAbgeschlossen && getAuftraegeNichtAbgeschlossen.length">
            <div class="list-row header">
                <div class="list-item">
                    <span>Auftrag:</span>
                </div>
                <div class="list-item">
                    <select :value="$route.params.id" @change="changeAuftrag">
                        <option value="-1">Bitte wählen..</option>
                        <option
                            v-for="entry of getAuftraegeNichtAbgeschlossen"
                            :key="'auftrag-' + entry.id"
                            :value="entry.id"
                            >{{ getAuftragTitle(entry) }}</option
                        >
                    </select>
                </div>
            </div>
            <template v-if="$route.params && $route.params.id && $route.params.id != '-1'">
                <ListRow
                    v-if="auftraegePositionenHeaders"
                    :items="auftraegePositionenHeaders"
                    :order-by="orderBy"
                    :order-direction="orderDirection"
                    header
                    @updateOrder="updateOrder"
                >
                </ListRow>
                <div class="list">
                    <ListRow
                        v-for="(itm, idx) of auftragPositionenListe"
                        :key="'auftrag-position' + idx"
                        :items="itm"
                    >
                        <select
                            class="count"
                            @change="
                                $set(
                                    countList,
                                    itm[0].id + '-' + itm[0].lager_id,
                                    $event.target.value
                                )
                            "
                        >
                            <option value="0">x 0</option>
                            <option
                                v-for="cnt of itm[2].key"
                                :key="'cnt-' + cnt + '-' + idx"
                                :value="cnt"
                                >x {{ cnt }}</option
                            >
                        </select>
                    </ListRow>
                </div>
                <div class="footer">
                    <Button
                        v-for="(button, i) of buttons"
                        :key="'Button' + i"
                        :button-style="button.buttonStyle"
                        :tag="button.tag"
                        @click="button.action === 'save' ? save() : discard()"
                    ></Button>
                </div>
            </template>
        </template>
        <NoItemFound v-else :item-definition="'Auftrag'" :goto="'auftraege-anlegen'"></NoItemFound>
    </main>
</template>

<script>
import { mapGetters } from 'vuex'
import ListRow from '@/components/ListRow.vue'
import Button from '@/components/Button.vue'
import orderMixin from '@/mixins/order'
import NoItemFound from '@/components/NoItemFound.vue'

export default {
    components: {
        ListRow,
        Button,
        NoItemFound
    },
    mixins: [orderMixin],
    data() {
        return {
            buttons: [
                { tag: 'Speichern & Abschicken', buttonStyle: 'button-global', action: 'save' },
                {
                    tag: 'Verwerfen',
                    buttonStyle: 'button-global button-close',
                    action: 'discard'
                }
            ],
            countList: []
        }
    },
    computed: {
        ...mapGetters([
            'auftraegePositionenHeaders',
            'getAuftraegeNichtAbgeschlossen',
            'auftragPositionenListe'
        ]),
        auftragPositionen: {
            get: function() {
                return this.$store.state.auftrag.positionen
            }
        },
        orderBy: {
            get: function() {
                return this.$store.state.auftrag.orderBy
            },
            set: function(val) {
                this.$store.commit('setAuftragOrderBy', val)
            }
        },
        orderDirection: {
            get: function() {
                return this.$store.state.auftrag.orderDirection
            },
            set: function(val) {
                this.$store.commit('setAuftragOrderDirection', val)
            }
        }
    },
    watch: {
        $route() {
            this.updateAuftraegePositionen()
        }
    },
    mounted() {
        this.orderBy = this.auftraegePositionenHeaders[0].key
        this.orderDirection = 'desc'
        this.updateAuftraegePositionen()
    },
    methods: {
        changeAuftrag: function(e) {
            this.$router.push({ name: 'auftraege-positionen', params: { id: e.target.value } })
        },
        updateAuftraegePositionen: function() {
            if (this.$route.params && this.$route.params.id && this.$route.params.id != '-1') {
                this.$store.dispatch('loadAuftraegePositionen')
            }
        },
        getAuftragTitle: function(auftrag) {
            return `${auftrag.id}. ${auftrag.kunde}${
                auftrag.bezeichnung ? ' - ' + auftrag.bezeichnung : ''
            }`
        },
        save: async function() {
            /**
             * Bestätigen, dass man den Auftrag abschließen möchte
             */
            const { value } = await this.$swal({
                text: `Sind Sie sich sicher, dass Sie den Auftrag abschließen möchten?`,
                showCancelButton: true,
                confirmButtonText: 'Bestätigen',
                cancelButtonText: 'Abbrechen'
            })
            if (value) {
                /**
                 * Bereitet die Artikelliste vor
                 */
                let artikel = []
                for (let key in this.countList) {
                    const split = key.split('-')
                    const id = split[0]
                    const lager_id = split[1]
                    for (let itm of this.auftragPositionen) {
                        if (itm.id == id && itm.lager_id == lager_id) {
                            artikel.push({
                                ...itm,
                                selectedCount: this.countList[key],
                                auftragsposition: 1
                            })
                        }
                    }
                }

                /**
                 * Auftrag anlegen
                 */
                const res = await this.$http.post('/index.php', {
                    action: 'finishAuftrag',
                    artikel,
                    auftrags_id: this.$route.params.id
                })

                /**
                 * Wenn anlegen erfolgreich
                 */
                const { data } = res
                if (data && data.success) {
                    const { value } = await this.$swal({ text: 'Auftrag abgeschlossen' })

                    /**
                     * Wenn box bestätigt wurde, dann alle Daten zurücksetzen und
                     * auf die Übersicht weiterleiten
                     */
                    if (value) {
                        this.discard()
                        this.$router.push({ name: 'auftraege-anzeigen' })
                    }
                } else {
                    await this.$swal({
                        text: res.data.msg,
                        type: 'error'
                    })
                }
            }
        },
        discard: function() {
            for (let itm of this.auftragPositionen) {
                itm.selectedCount = 0
            }
        }
    },
    metaInfo() {
        return {
            title: 'Aufträge positionen'
        }
    }
}
</script>

<style lang="scss" src="@/components/ListRow.scss" scoped></style>
<style lang="scss" scoped>
.footer {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    height: 52px;
    padding: 0 1rem;
    position: absolute;
    bottom: 0;
    background-color: white;
    width: 100%;
}
</style>
