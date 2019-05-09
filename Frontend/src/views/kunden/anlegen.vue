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
            title: 'Kunden anlegen'
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
            header: { section: 'Kunde', action: 'Anlegen' }
        }
    },
    computed: {
        inputs: {
            get() {
                return this.$store.state.kunde.inputs
            },
            set(value) {
                this.setKundenInputs(value)
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
                action: 'addKunde',
                id: obj.id,
                name: obj.Name,
                vorname: obj.Vorname,
                strasse: obj.Strasse,
                hausnummer: obj.Hausnummer,
                plz: obj.Plz,
                ort: obj.Ort,
                telefon: obj.Telefon,
                email: obj.Email
                // inaktiv: 0
            })

            /**
             * Wenn anlegen erfolgreich
             */
            const { data } = res
            if (data && data.success) {
                const { value } = await this.$swal({ text: 'Kunde erfolgreich angelegt' })

                /**
                 * Wenn box bestätigt wurde, dann alle Daten zurücksetzen und
                 * auf die Übersicht weiterleiten
                 */
                if (value) {
                    this.discard()
                    this.$router.push({ name: 'kunde-anzeigen' })
                }
            } else {
                console.error(res)
            }
        }
    }
}
</script>
