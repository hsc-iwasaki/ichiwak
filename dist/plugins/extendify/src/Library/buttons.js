import { subscribe } from '@wordpress/data'
import { PluginSidebarMoreMenuItem } from '@wordpress/edit-post'
import { render } from '@wordpress/element'
import { Icon } from '@wordpress/icons'
import { registerPlugin } from '@wordpress/plugins'
import LibraryAccessModal from '@library/components/LibraryAccessModal'
import { CtaButton, MainButtonWrapper } from '@library/components/MainButtons'
import { brandMark } from '@library/components/icons/'

const userState = window.extendifyData?.user?.state
const isAdmin = () => window.extendifyData.user === null || userState?.isAdmin
const isGlobalLibraryEnabled = () =>
    window.extendifyData.sitesettings === null ||
    window.extendifyData?.sitesettings?.state?.enabled
const isLibraryEnabled = () =>
    window.extendifyData.user === null
        ? isGlobalLibraryEnabled()
        : userState?.enabled

// Add the MAIN button when Gutenberg is available and ready
const unsubMainBtn = subscribe(() => {
    requestAnimationFrame(() => {
        if (document.getElementById('extendify-templates-inserter')) {
            return
        }
        if (
            !document.querySelector('.edit-post-header-toolbar') &&
            !document.querySelector('.edit-site-header-edit-mode__start') // FSE
        ) {
            return
        }
        if (!isGlobalLibraryEnabled() && !isAdmin()) {
            return unsubMainBtn()
        }
        const buttonContainer = Object.assign(document.createElement('div'), {
            id: 'extendify-templates-inserter',
        })
        // Standard block editor
        document
            .querySelector('.edit-post-header-toolbar')
            ?.append(buttonContainer)
        // FSE block editor
        document
            .querySelector('.edit-site-header-edit-mode__start')
            ?.append(buttonContainer)

        render(<MainButtonWrapper />, buttonContainer)

        if (!isLibraryEnabled()) {
            document
                .getElementById('extendify-templates-inserter-btn')
                .classList.add('hidden')
        }
    })
})

// The CTA button inside patterns
const finish2 = subscribe(() => {
    requestAnimationFrame(() => {
        if (!isGlobalLibraryEnabled() && !isAdmin()) {
            return
        }
        if (!document.querySelector('[id$=patterns-view]')) {
            return
        }
        if (document.getElementById('extendify-cta-button')) {
            return
        }
        const ctaButtonContainer = Object.assign(
            document.createElement('div'),
            { id: 'extendify-cta-button-container' },
        )

        document
            .querySelector('[id$=patterns-view]')
            .prepend(ctaButtonContainer)
        render(<CtaButton />, ctaButtonContainer)

        finish2()
    })
})

// This will add a button to enable or disable the library button
const LibraryEnableDisable = () => {
    const setOpenSiteSettingsModal = () => {
        const util = document.getElementById('extendify-util')
        render(<LibraryAccessModal />, util)
    }
    // If the url isn't post.php or post-new.php, don't show the button
    const href = window.location.href
    if (!href.includes('post.php') && !href.includes('post-new.php')) {
        return null
    }

    return (
        <PluginSidebarMoreMenuItem
            onClick={setOpenSiteSettingsModal}
            icon={<Icon icon={brandMark} size={24} />}>
            {' '}
            Extendify
        </PluginSidebarMoreMenuItem>
    )
}

// Load this button always, which is used to enable or disable
// FSE doesn't seem to recognize registerPlugin (yet)
try {
    registerPlugin('extendify-settings-enable-disable', {
        render: LibraryEnableDisable,
    })
} catch (e) {
    console.error(
        'registerPlugin not supported? (error handled gracefully)',
        e.message,
    )
}
