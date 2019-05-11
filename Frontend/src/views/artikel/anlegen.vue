<template>
    <main>
        <ModalView
            :inputs="inputs"
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
            title: 'Artikel anlegen'
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
            header: { section: 'Artikel', action: 'Anlegen' }
        }
    },
    computed: {
        inputs: {
            get() {
                return this.$store.state.artikel.inputs
            },
            set(value) {
                this.setArtikelInputs(value)
            }
        }
    },
    methods: {
        discard: function() {
            /**
             * Setzt alle Werte der Input felder zurück
             */
            this.inputs.forEach(el => {
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
            for (let ip of this.inputs) {
                obj[ip.name] = ip.value
            }

            /**
             * Artikel anlegen
             */
            const res = await this.$http.post('/index.php', {
                action: 'addArtikel',
                ean: obj.EAN,
                bezeichnung: obj.Bezeichung,
                kurztext: obj.Kurztext,
                preis: obj.Preis.replace(',', '.'),
                bild: '',
                inaktiv: 0
            })

            /**
             * Wenn anlegen erfolgreich
             */
            const { data } = res
            if (data && data.success) {
                const { value } = await this.$swal({ text: 'Artikel erfolgreich angelegt' })

                /**
                 * Wenn box bestätigt wurde, dann alle Daten zurücksetzen und
                 * auf die Übersicht weiterleiten
                 */
                if (value) {
                    this.discard()
                    this.$router.push({ name: 'artikel-anzeigen' })
                }
            } else {
                console.error(res)
            }
        }
    }
}
</script>
