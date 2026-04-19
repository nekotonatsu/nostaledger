import { useEffect, useState } from 'react'
import axios from 'axios'

interface Props {
    apiEndpoint: string
    onCancel: () => void
}

interface Tag {
    id: number
    tag_name: string
}

const API_URL = import.meta.env.VITE_API_URL ?? '/api'

const config = {
    'daily-expenditures': {
        tagEndpoint: 'daily-expenditure-tags',
        relationEndpoint: 'daily-expenditure-daily-expenditure-tag-relations',
        expenditureKey: 'daily_expenditure_id',
        tagKey: 'daily_expenditure_tag_id',
    },
    'must-expenditures': {
        tagEndpoint: 'must-expenditure-tags',
        relationEndpoint: 'must-expenditure-must-expenditure-tag-relations',
        expenditureKey: 'must_expenditure_id',
        tagKey: 'must_expenditure_tag_id',
    },
} as const

export default function AddExpenditureForm({ apiEndpoint, onCancel }: Props) {
    const [expenseName, setExpenseName] = useState('')
    const [amount, setAmount] = useState('')
    const [expenseAt, setExpenseAt] = useState('')
    const [tagId, setTagId] = useState<number | ''>('')
    const [tags, setTags] = useState<Tag[]>([])
    const [isSubmitting, setIsSubmitting] = useState(false)

    const cfg = config[apiEndpoint as keyof typeof config]

    useEffect(() => {
        if (!cfg) return
        axios.get<Tag[]>(`${API_URL}/${cfg.tagEndpoint}`, { withCredentials: true })
            .then((res) => setTags(res.data))
    }, [apiEndpoint])

    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault()
        setIsSubmitting(true)
        try {
            const res = await axios.post(
                `${API_URL}/${apiEndpoint}`,
                { expense_name: expenseName, amount: Number(amount), expense_at: expenseAt },
                { withCredentials: true }
            )
            if (cfg && tagId !== '') {
                await axios.post(
                    `${API_URL}/${cfg.relationEndpoint}`,
                    { [cfg.expenditureKey]: res.data.id, [cfg.tagKey]: tagId },
                    { withCredentials: true }
                )
            }
            setExpenseName('')
            setAmount('')
            setExpenseAt('')
            setTagId('')
            window.dispatchEvent(new CustomEvent('expenditure-registered'))
            onCancel()
        } finally {
            setIsSubmitting(false)
        }
    }

    return (
        <form onSubmit={handleSubmit} className="space-y-3 mt-2">
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
            {cfg && (
                <div>
                    <label className="block text-xs text-gray-500 mb-1">タグ</label>
                    <select
                        value={tagId}
                        onChange={(e) => setTagId(e.target.value === '' ? '' : Number(e.target.value))}
                        className="w-full border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-1 focus:ring-indigo-400"
                    >
                        <option value="">タグを選択</option>
                        {tags.map((tag) => (
                            <option key={tag.id} value={tag.id}>{tag.tag_name}</option>
                        ))}
                    </select>
                </div>
            )}
            <div className="flex gap-2 pt-1">
                <button
                    type="button"
                    onClick={onCancel}
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
    )
}
