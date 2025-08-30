class berryScroll extends berryBase {
    is_single: boolean = false;
    constructor() {
        super();
        this.is_single = this.obvInit.is_single;

        if (document.querySelector('.backToTop')) {
            const backToTop = document.querySelector('.backToTop') as HTMLElement;
            window.addEventListener('scroll', () => {
                const t = window.scrollY || window.pageYOffset;
                t > 200
                    ? backToTop!.classList.add('is-active')
                    : backToTop!.classList.remove('is-active');
            });

            backToTop.addEventListener('click', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }
    }
}

new berryScroll();
