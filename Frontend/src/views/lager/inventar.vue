<template>
    <main>
        <div class="list-row header">
            <div class="list-item">
                <span>Lager:</span>
            </div>
            <div class="list-item">
                <select :value="$route.params.id" @change="changeLager">
                    <option value="-1">Bitte wählen..</option>
                    <option
                        v-for="entry of getLager"
                        :key="'lager-' + entry.id"
                        :value="entry.id"
                        >{{ entry.bezeichnung }}</option
                    >
                </select>
            </div>
        </div>
        <template v-if="$route.params && $route.params.id && $route.params.id != '-1'">
            <ListRow
                v-if="lagerInventarHeaders"
                :items="lagerInventarHeaders"
                :order-by="orderBy"
                :order-direction="orderDirection"
                header
                @updateOrder="updateOrder"
            ></ListRow>
            <TheLagerList :items="lagerInventarListe"></TheLagerList>
        </template>
    </main>
</template>

<script>
import { mapGetters } from 'vuex'
import ListRow from '@/components/ListRow.vue'
import TheLagerList from '@/views/lager/components/TheLagerList.vue'
import orderMixin from '@/mixins/order'

export default {
    components: {
        ListRow,
        TheLagerList
    },
    mixins: [orderMixin],
    methods: {
        changeLager: function(e) {
            this.$router.push({ name: 'lager-inventar', params: { id: e.target.value } })
        },
        updateLagerInventar: function() {
            if (this.$route.params && this.$route.params.id && this.$route.params.id != '-1') {
                this.$store.dispatch('loadLagerInventar', this.$route.params.id)
            }
        }
    },
    computed: {
        ...mapGetters(['lagerInventarListe', 'lagerInventarHeaders', 'getLager']),
        orderBy: {
            get: function() {
                return this.$store.state.lager.orderBy
            },
            set: function(val) {
                this.$store.commit('setLagerOrderBy', val)
            }
        },
        orderDirection: {
            get: function() {
                return this.$store.state.lager.orderDirection
            },
            set: function(val) {
                this.$store.commit('setLagerOrderDirection', val)
            }
        }
    },
    watch: {
        $route() {
            this.updateLagerInventar()
        }
    },
    mounted() {
        this.orderBy = 'id'
        this.orderDirection = 'desc'
        this.updateLagerInventar()
    },
    metaInfo() {
        return {
            title: 'Lager'
        }
    }
}
</script>

<style lang="scss" src="@/components/ListRow.scss" scoped></style>
