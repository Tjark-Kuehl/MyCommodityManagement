<template>
    <main>
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
                    :key="'list-auftrag' + idx"
                    :items="itm"
                >
                    <select id="" name="">
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
        </template>
    </main>
</template>

<script>
import { mapGetters } from 'vuex'
import ListRow from '@/components/ListRow.vue'
import orderMixin from '@/mixins/order'

export default {
    components: {
        ListRow
    },
    mixins: [orderMixin],
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
        }
    },
    computed: {
        ...mapGetters([
            'auftragPositionenListe',
            'auftraegePositionenHeaders',
            'getAuftraegeNichtAbgeschlossen'
        ]),
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
    metaInfo() {
        return {
            title: 'Aufträge positionen'
        }
    }
}
</script>

<style lang="scss" src="@/components/ListRow.scss" scoped></style>
