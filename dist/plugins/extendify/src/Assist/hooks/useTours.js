import useSWR from 'swr'
import { getTours } from '@assist/api/Data'

export const useTours = () => {
    const { data: tours, error } = useSWR(
        'tours',
        async () => {
            const response = await getTours()

            if (!response?.data || !Array.isArray(response.data)) {
                console.error(response)
                throw new Error('Bad data')
            }

            return response.data
        },
        {
            refreshInterval: 360_000,
            revalidateOnFocus: false,
            dedupingInterval: 360_000,
        },
    )

    return { tours, error, loading: !tours && !error }
}
