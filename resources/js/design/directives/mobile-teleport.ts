interface Ctx {
    expression: string
}
document.addEventListener('alpine:init', () => {
    Alpine.directive('mobile-teleport', (el: HTMLElement, { expression }:Ctx) => {
        const targetSelector = expression
        const target = document.querySelector(targetSelector)

        if (!target) {
            console.warn('mobile-teleport: target not found:', targetSelector)
            return
        }

        const originalParent = el.parentNode
        const originalNext = el.nextSibling

        const mq = window.matchMedia('(max-width: 768px)')

        const update = () => {
            if (mq.matches) {
                target.appendChild(el)
            } else {
                if (originalNext) {
                    originalParent?.insertBefore(el, originalNext)
                } else {
                    originalParent?.appendChild(el)
                }
            }
        }

        update()
        mq.addEventListener('change', update)
    })
})
