import { useEffect, useState } from 'react'
import axios from 'axios'

interface Transaction {
  id: number
  title: string
  amount: number
  type: 'income' | 'expense'
  category: string
  date: string
}

const API_URL = import.meta.env.VITE_API_URL ?? '/api'

export default function Transactions() {
  const [transactions, setTransactions] = useState<Transaction[]>([])
  const [loading, setLoading] = useState(true)

  useEffect(() => {
    axios
      .get<Transaction[]>(`${API_URL}/transactions`)
      .then((res) => setTransactions(res.data))
      .catch(() => {
        // APIが未実装でも表示できるようにデフォルト値のまま
      })
      .finally(() => setLoading(false))
  }, [])

  const fmt = (n: number) =>
    new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(n)

  if (loading) {
    return <p className="text-center text-gray-400 py-12">読み込み中...</p>
  }

  return (
    <div>
      <h2 className="text-2xl font-bold text-gray-800 mb-6">取引一覧</h2>
      {transactions.length === 0 ? (
        <div className="bg-white rounded-xl shadow p-8 text-center text-gray-400">
          取引データがありません
        </div>
      ) : (
        <div className="bg-white rounded-xl shadow overflow-hidden">
          <table className="w-full text-sm">
            <thead className="bg-gray-50 text-gray-500">
              <tr>
                <th className="px-4 py-3 text-left">日付</th>
                <th className="px-4 py-3 text-left">タイトル</th>
                <th className="px-4 py-3 text-left">カテゴリ</th>
                <th className="px-4 py-3 text-right">金額</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-gray-100">
              {transactions.map((t) => (
                <tr key={t.id}>
                  <td className="px-4 py-3 text-gray-500">{t.date}</td>
                  <td className="px-4 py-3 text-gray-800">{t.title}</td>
                  <td className="px-4 py-3 text-gray-500">{t.category}</td>
                  <td
                    className={`px-4 py-3 text-right font-medium ${
                      t.type === 'income' ? 'text-green-600' : 'text-red-500'
                    }`}
                  >
                    {t.type === 'income' ? '+' : '-'}
                    {fmt(t.amount)}
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      )}
    </div>
  )
}
