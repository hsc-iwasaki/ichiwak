import { InspectorAdvancedControls } from '@wordpress/block-editor'
import { FormTokenField } from '@wordpress/components'
import { createHigherOrderComponent } from '@wordpress/compose'
import { addFilter } from '@wordpress/hooks'
import { __, sprintf } from '@wordpress/i18n'
import suggestions from '../../../utility-framework/suggestions.json'

function addAttributes(settings) {
    // Add new extUtilities attribute to block settings.
    return {
        ...settings,
        attributes: {
            ...settings.attributes,
            extUtilities: {
                type: 'array',
                default: [],
            },
        },
    }
}

function addEditProps(settings) {
    const existingGetEditWrapperProps = settings.getEditWrapperProps
    settings.getEditWrapperProps = (attributes) => {
        let props = {}

        if (existingGetEditWrapperProps) {
            props = existingGetEditWrapperProps(attributes)
        }

        return addSaveProps(props, settings, attributes)
    }

    return settings
}

// Create HOC to add Extendify Utility to Advanced Panel of block.
const utilityClassEdit = createHigherOrderComponent((BlockEdit) => {
    return function editPanel(props) {
        const classes = props?.attributes?.extUtilities ?? []
        const suggestionList = suggestions.suggestions.map((s) => {
            // Remove all extra // and . from classnames
            return s.replace('.', '').replace(new RegExp('\\\\', 'g'), '')
        })

        return (
            <>
                <BlockEdit {...props} />
                {classes && (
                    <InspectorAdvancedControls>
                        <FormTokenField
                            label={sprintf(
                                // translators: %s: The name of the plugin, Extendify.
                                __('%s Utilities', 'extendify'),
                                'Extendify',
                            )}
                            tokenizeOnSpace={true}
                            value={classes}
                            suggestions={suggestionList}
                            onChange={(value) => {
                                props.setAttributes({
                                    extUtilities: value,
                                })
                            }}
                        />
                        <p>
                            {__(
                                '* Extendify utilities will be removed in an upcoming release. See the plugin readme for more information.',
                                'extendify',
                            )}
                        </p>
                    </InspectorAdvancedControls>
                )}
            </>
        )
    }
}, 'utilityClassEdit')

function addSaveProps(saveElementProps, blockType, attributes) {
    const generatedClasses = saveElementProps?.className ?? []
    const classes = attributes?.extUtilities ?? []
    const additionalClasses = attributes?.className ?? []

    if (!classes || !Object.keys(classes).length) {
        return saveElementProps
    }

    // EK seems to be converting string values to objects in some situations
    const normalizeAsArray = (item) => {
        switch (Object.prototype.toString.call(item)) {
            case '[object String]':
                return item.split(' ')
            case '[object Array]':
                return item
            default:
                return []
        }
    }
    const classesCombined = new Set([
        ...normalizeAsArray(additionalClasses),
        ...normalizeAsArray(generatedClasses),
        ...normalizeAsArray(classes),
    ])

    return Object.assign({}, saveElementProps, {
        className: [...classesCombined].join(' '),
    })
}

addFilter(
    'blocks.registerBlockType',
    'extendify/utilities/attributes',
    addAttributes,
)

addFilter(
    'blocks.registerBlockType',
    'extendify/utilities/addEditProps',
    addEditProps,
)

addFilter(
    'editor.BlockEdit',
    'extendify/utilities/advancedClassControls',
    utilityClassEdit,
)

addFilter(
    'blocks.getSaveContent.extraProps',
    'extendify/utilities/extra-props',
    addSaveProps,
)
