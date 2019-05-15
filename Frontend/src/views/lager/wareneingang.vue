<template>
    <main>
        <ModalView
            :inputs="wareneingang_inputs"
            :buttons="buttons"
            :header="header"
            @save="save()"
            @discard="discard()"
        />
    </main>
</template>

<script>
import ModalView from '@/components/ModalView.vue'
//
export default {
    metaInfo() {
        return {
            title: 'Lager Wareneingang'
        }
    },
    components: {
        ModalView
    },
    data() {
        return {
            buttons: [
                { tag: 'Speichern', buttonStyle: 'button-global', action: 'save' },
                {
                    tag: 'Verwerfen',
                    buttonStyle: 'button-global button-close',
                    action: 'discard'
                }
            ],
            header: { section: 'Lager', action: 'Wareneingang' }
        }
    },
    computed: {
        wareneingang_inputs: {
            get() {
                return this.$store.state.lager.wareneingang_inputs
            },
            set(value) {
                this.setLagerWareneingang(value)
            }
        }
    },
    methods: {
        discard: function() {
            /**
             * Setzt alle Werte der Input felder zurück
             */
            this.wareneingang_inputs.forEach(el => {
                if (el.default) {
                    el.value = el.default
                } else {
                    el.value = ''
                }
            })
        },
        save: async function() {
            /**
             * Daten neu Mappen für einen einfachen zugriff
             */
            let obj = {}
            for (let ip of this.wareneingang_inputs) {
                obj[ip.name] = ip.value
            }

            /**
             * Lager anlegen
             */
            const res = await this.$http.post('/index.php', {
                action: 'addLagerArtikel',
                artikel_id: obj.Artikel,
                lager_id: obj.Lager,
                menge: obj.Menge
            })

            /**
             * Wenn anlegen erfolgreich
             */
            const { data } = res
            if (data && data.success) {
                const { value } = await this.$swal({
                    text: `Artikel hinzugefügt`,
                    showCancelButton: true,
                    cancelButtonColor: '#bdbdbd',
                    confirmButtonText: 'Zur Übersicht',
                    cancelButtonText: 'Weitere Artikel hinzufügen'
                })
                if (value) {
                    this.$router.push({ name: 'lager-inventar', params: { id: obj.Lager } })
                    this.discard()
                }
            } else {
                await this.$swal({
                    text: res.data.msg,
                    type: 'error'
                })
            }
        }
    }
}
</script>
