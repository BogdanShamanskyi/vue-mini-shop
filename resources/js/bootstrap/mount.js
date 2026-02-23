import { createApp, h } from 'vue'

export function mountWidgets({ pinia, widgets }) {
    const roots = document.querySelectorAll('[data-vue-root]')

    roots.forEach((el) => {
        const name = el.getAttribute('data-vue-root')
        const Component = widgets[name]
        if (!Component) return

        let props = {}
        const raw = el.getAttribute('data-props')
        if (raw) {
            try {
                props = JSON.parse(raw)
            } catch {
                props = {}
            }
        }

        createApp({ render: () => h(Component, props) })
            .use(pinia)
            .mount(el)
    })
}
