<template>
    <main>
        <div class="list-row header">
            <div class="list-item">
                <span>Lager:</span>
            </div>
            <div class="list-item">
                <select v-model="lagerSelected">
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
        <template v-if="lagerSelected != '-1'">
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
    data() {
        return {
            lagerSelected: '-1'
        }
    },
    watch: {
        lagerSelected: function() {
            if (this.lagerSelected != '-1') {
                this.$store.dispatch('loadLagerInventar', this.lagerSelected)
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
    mounted() {
        this.orderBy = 'id'
        this.orderDirection = 'desc'
    },
    metaInfo() {
        return {
            title: 'Lager'
        }
    }
}
</script>

<style lang="scss" src="@/components/ListRow.scss" scoped></style>
