import { useEffect, useState, UIEvent } from 'react'
import axios from 'axios'

interface MustExpenditure {
    id: number
    expense_name: string
    amount: number
}

const API_URL = import.meta.env.VITE_API_URL ?? '/api'

export default function MustExpenditureTextGraph() {
    const [list, setList] = useState<MustExpenditure[]>([])
    const [atBottom, setAtBottom] = useState(false)

    const fetchData = () => {
        axios.get<MustExpenditure[]>(
            `${API_URL}/must-expenditures`,
            { withCredentials: true }
        ).then((res) => setList(res.data))
        .catch(() => {})
    }

    useEffect(() => {
        fetchData()
        window.addEventListener('expenditure-registered', fetchData)
        return () => window.removeEventListener('expenditure-registered', fetchData)
    }, [])

    const handleScroll = (e: UIEvent<HTMLDivElement>) => {
        const el = e.currentTarget
        setAtBottom(el.scrollTop + el.clientHeight >= el.scrollHeight - 4)
    }

    return (
        <div>
            <div className="relative">
                <div
                    className="space-y-2 max-h-64 overflow-y-scroll border py-2 bg-white custom-scrollbar"
                    onScroll={handleScroll}
                >
                    <div className="flex justify-between items-center border-b border-gray-200 pb-2 text-sm font-bold px-2">
                        <span className="w-2/3 text-gray-700">支出名</span>
                        <span className="w-1/3 text-right text-gray-700">金額</span>
                    </div>
                    {list.map((item) => (
                        <div key={item.id} className="flex justify-between items-center border-b border-gray-100 py-1 text-sm px-2">
                            <span className="w-2/3 text-gray-800">{item.expense_name}</span>
                            <span className="w-1/3 text-right font-medium text-gray-800">{item.amount.toLocaleString()}円</span>
                        </div>
                    ))}
                    {list.length === 0 && (
                        <p className="text-gray-400 text-sm px-2">データがありません</p>
                    )}
                </div>
                {!atBottom && list.length > 0 && (
                    <div className="absolute bottom-0 left-0 right-0 h-10 bg-gradient-to-t from-white to-transparent pointer-events-none" />
                )}
            </div>
            {!atBottom && list.length > 0 && (
                <p className="text-xs text-gray-400 text-center mt-1">↓ スクロールでもっと見る</p>
            )}
        </div>
    )
}
