import { useEffect, useState } from 'react'
import axios from 'axios'

interface AmountByTag {
    tag_id: number
    tag_name: string
    total_amount: number
}

const API_URL = import.meta.env.VITE_API_URL ?? '/api'

export default function AllExpenditure() {
    const [expenditures, setExpenditures] = useState<AmountByTag[]>([])

    const fetchData = () => {
        axios.get<AmountByTag[]>(
            `${API_URL}/daily-expenditure-daily-expenditure-tag-relations/amount-by-tag`,
            { withCredentials: true }
        ).then((res) => setExpenditures(res.data))
    }

    useEffect(() => {
        fetchData()
        window.addEventListener('expenditure-registered', fetchData)
        return () => window.removeEventListener('expenditure-registered', fetchData)
    }, [])

    const maxAmount = Math.max(...expenditures.map((item) => item.total_amount), 1)

    return (
        <div className="p-4 space-y-3">
            {expenditures.map((item) => (
                <div key={item.tag_id}>
                    <div className="flex justify-between text-sm mb-1">
                        <span className="font-medium">{item.tag_name}</span>
                        <span className="text-gray-600">{item.total_amount.toLocaleString()}円</span>
                    </div>
                    <div className="w-full bg-gray-200 rounded-full h-4">
                        <div
                            className="bg-blue-500 h-4 rounded-full transition-all duration-500"
                            style={{ width: `${(item.total_amount / maxAmount) * 100}%` }}
                        />
                    </div>
                </div>
            ))}
            {expenditures.length === 0 && (
                <p className="text-gray-400 text-sm">データがありません</p>
            )}
        </div>
    )
}