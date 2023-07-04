import { useLayoutEffect, useState, useCallback } from '@wordpress/element'
import { getOption } from '@assist/api/WPApi'
import { useTasksStore } from '@assist/state/Tasks'

export const InternalLinkButton = ({ task, className }) => {
    const { completeTask } = useTasksStore()
    const [link, setLink] = useState(
        task.slug === 'edit-homepage' ? null : task.internalLink,
    )
    const handleClick = useCallback(() => {
        // If no dependency then complete the task
        !task.doneDependencies && completeTask(task.slug)
    }, [task, completeTask])

    useLayoutEffect(() => {
        if (task.slug === 'edit-homepage') {
            const split = task.internalLink.split('$')
            getOption('page_on_front').then((id) => {
                setLink(split[0] + id + split[1])
            })
        }
    }, [task])

    if (!link) return null
    return (
        <a
            href={window.extAssistData.adminUrl + link}
            target="_blank"
            rel="noreferrer"
            className={className}
            onClick={handleClick}>
            {task.buttonTextToDo}
        </a>
    )
}
