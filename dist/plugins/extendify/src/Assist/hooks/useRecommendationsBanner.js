import useSWR from 'swr'
import { getRecommendationsBanner } from '@assist/api/Data'

export const useRecommendationsBanner = () => {
    const { data: recommendationsBanner, error } = useSWR(
        'recommendationsBanner',
        async () => {
            const response = await getRecommendationsBanner()
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

    return {
        recommendationsBanner,
        error,
        loading: !recommendationsBanner && !error,
    }
}
