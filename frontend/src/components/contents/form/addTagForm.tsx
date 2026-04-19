import { useState } from 'react'
import axios from 'axios'

interface Props {
    apiEndpoint: string
    onCancel: () => void
}

const API_URL = import.meta.env.VITE_API_URL ?? '/api'

export default function AddTagForm({ apiEndpoint, onCancel }: Props) {
    const [tagName, setTagName] = useState('')
    const [isSubmitting, setIsSubmitting] = useState(false)

    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault()
        setIsSubmitting(true)
        try {
            await axios.post(
                `${API_URL}/${apiEndpoint}`,
                { tag_name: tagName },
                { withCredentials: true }
            )
            setTagName('')
            onCancel()
        } finally {
            setIsSubmitting(false)
        }
    }

    return (
        <form onSubmit={handleSubmit} className="space-y-3 mt-2">
            <div>
                <label className="block text-xs text-gray-500 mb-1">タグ名</label>
                <input
                    type="text"
                    value={tagName}
                    onChange={(e) => setTagName(e.target.value)}
                    required
                    className="w-full border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-1 focus:ring-indigo-400"
                />
            </div>
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
