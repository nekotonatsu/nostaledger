import { useState } from 'react'
import axios from 'axios'

interface Props {
    headerMessage: string
    to: string
    apiEndpoint: string
}

const API_URL = import.meta.env.VITE_API_URL ?? '/api'

export default function ExpenditureHeader({ headerMessage, apiEndpoint }: Props) {
    const [isOpen, setIsOpen] = useState(false)
    const [expenseName, setExpenseName] = useState('')
    const [amount, setAmount] = useState('')
    const [expenseAt, setExpenseAt] = useState('')
    const [isSubmitting, setIsSubmitting] = useState(false)

    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault()
        setIsSubmitting(true)
        try {
            await axios.post(
                `${API_URL}/${apiEndpoint}`,
                { expense_name: expenseName, amount: Number(amount), expense_at: expenseAt },
                { withCredentials: true }
            )
            setExpenseName('')
            setAmount('')
            setExpenseAt('')
            setIsOpen(false)
        } finally {
            setIsSubmitting(false)
        }
    }

    return (
        <div className="relative">
            <button
                onClick={() => setIsOpen(!isOpen)}
                className="flex items-center gap-1 text-sm font-medium text-gray-700 hover:text-indigo-600 transition-colors"
            >
                {headerMessage}
                <span className="text-xs">{isOpen ? '▲' : '▼'}</span>
            </button>

            {isOpen && (
                <div className="absolute left-0 mt-2 w-64 bg-white rounded-lg shadow-lg border border-gray-100 p-4 z-50">
                    <form onSubmit={handleSubmit} className="space-y-3">
                        <div>
                            <label className="block text-xs text-gray-500 mb-1">支出名</label>
                            <input
                                type="text"
                                value={expenseName}
                                onChange={(e) => setExpenseName(e.target.value)}
                                required
                                className="w-full border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-1 focus:ring-indigo-400"
                            />
                        </div>
                        <div>
                            <label className="block text-xs text-gray-500 mb-1">金額（円）</label>
                            <input
                                type="number"
                                value={amount}
                                onChange={(e) => setAmount(e.target.value)}
                                required
                                min={0}
                                className="w-full border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-1 focus:ring-indigo-400"
                            />
                        </div>
                        <div>
                            <label className="block text-xs text-gray-500 mb-1">日付</label>
                            <input
                                type="date"
                                value={expenseAt}
                                onChange={(e) => setExpenseAt(e.target.value)}
                                required
                                className="w-full border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-1 focus:ring-indigo-400"
                            />
                        </div>
                        <div className="flex gap-2 pt-1">
                            <button
                                type="button"
                                onClick={() => setIsOpen(false)}
                                className="flex-1 text-sm text-gray-500 border border-gray-300 rounded py-1 hover:bg-gray-50"
                            >
                                キャンセル
                            </button>
                            <button
                                type="submit"
                                disabled={isSubmitting}
                                className="flex-1 text-sm text-white bg-indigo-500 rounded py-1 hover:bg-indigo-600 disabled:opacity-50"
                            >
                                {isSubmitting ? '登録中…' : '登録'}
                            </button>
                        </div>
                    </form>
                </div>
            )}
        </div>
    )
}
