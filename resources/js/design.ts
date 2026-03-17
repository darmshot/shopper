import Alpine from '@alpinejs/csp'
import '@/design/directives/mobile-teleport'

window.Alpine = Alpine

document.addEventListener('DOMContentLoaded', () => {
    Alpine.start()
})
