import { useEffect, useState } from 'react'
import axios from 'axios'

interface DailyExpenditureWithTag {
    expense_name: string
    amount: number
    expense_at: string
    tag_name: string
}

const API_URL = import.meta.env.VITE_API_URL ?? '/api'

export default function TextGraph() {
    const [list, setList] = useState<DailyExpenditureWithTag[]>([])

    const fetchData = () => {
        axios.get<DailyExpenditureWithTag[]>(
            `${API_URL}/daily-expenditure-daily-expenditure-tag-relations/expenditures-with-tag`,
            { withCredentials: true }
        ).then((res) => setList(res.data))
    }

    useEffect(() => {
        fetchData()
        window.addEventListener('expenditure-registered', fetchData)
        return () => window.removeEventListener('expenditure-registered', fetchData)
    }, [])

    return (
        <>
            <div className="space-y-3 w-250 max-h-64 overflow-y-scroll border py-2">
                <div className='w-200 flex justify-between items-center border-b border-gray-100 py-2 text-sm'>
                    <div className="flex items-center gap-2 w-2/5 bg-blue-500">
                        <span className="text-xs text-white w-1/2 bg-indigo-400 rounded px-2 py-0.5 text-center">タグ名</span>
                        <span className="text-gray-800 w-1/2 text-center">支払い名</span>
                    </div>
                    <div className="flex items-center gap-4 text-gray-500 w-3/5 bg-red-500">
                        <span className='text-center w-1/2'>支払日</span>
                        <span className="font-medium text-gray-800 text-center w-1/2">金額</span>
                    </div>
                </div>
                <hr></hr>
                {list.map((item, index) => (
                    <div key={index} className="flex justify-between items-center border-b border-gray-100 py-2 text-sm">
                        <div className="flex items-center gap-2 w-2/5 bg-blue-500">
                            <span className="text-xs text-white w-1/2 bg-indigo-400 rounded px-2 py-0.5 text-center">{item.tag_name}</span>
                            <span className="text-gray-800 w-1/2 text-center">{item.expense_name}</span>
                        </div>
                        <div className="flex items-center gap-4 text-gray-500 w-3/5 bg-red-500">
                            <span className='text-center w-1/2'>{item.expense_at.slice(0, 10)}</span>
                            <span className="font-medium text-gray-800 text-center w-1/2">{item.amount.toLocaleString()}円</span>
                        </div>
                    </div>
                ))}
                {list.length === 0 && (
                    <p className="text-gray-400 text-sm">データがありません</p>
                )}
            </div>
        </>
    )
}
