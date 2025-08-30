interface obvInit {
    archive_id: any;
    nonce: string;
    restfulBase: string;
    is_single: boolean;
    post_id: number;
    is_archive: boolean;
    darkmode: boolean;
    version: string;
    like_success_text: string;
    copy_success_text: string;
    now_text: string;
    comment_success_text: string;
}

class berryBase {
    is_single: boolean = false;
    post_id: number = 0;
    is_archive: boolean = false;
    darkmode: any = false;
    VERSION: string;
    obvInit: obvInit;

    constructor() {
        this.obvInit = (window as unknown as Window & { obvInit: obvInit }).obvInit;
        this.is_single = this.obvInit.is_single;
        this.post_id = this.obvInit.post_id;
        this.is_archive = this.obvInit.is_archive;
        this.darkmode = this.obvInit.darkmode;
        this.VERSION = this.obvInit.version;
    }

    getCookie(t: any) {
        if (0 < document.cookie.length) {
            var e = document.cookie.indexOf(t + '=');
            if (-1 != e) {
                e = e + t.length + 1;
                var n = document.cookie.indexOf(';', e);
                return -1 == n && (n = document.cookie.length), document.cookie.substring(e, n);
            }
        }
        return '';
    }

    setCookie(t: any, e: any, n: any) {
        var o = new Date();
        o.setTime(o.getTime() + 24 * n * 60 * 60 * 1e3);
        var i = 'expires=' + o.toUTCString();
        document.cookie = t + '=' + e + ';' + i + ';path=/';
    }

    showNotice(message: any, type: any = 'success') {
        const html = `<div class="notice--wrapper">${message}</div>`;

        document.querySelector('body')!.insertAdjacentHTML('beforeend', html);

        document.querySelector('.notice--wrapper')!.classList.add('is-active');

        setTimeout(() => {
            document.querySelector('.notice--wrapper')!.remove();
        }, 3000);
    }
}
