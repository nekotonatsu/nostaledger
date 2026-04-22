import { useEffect, useState } from 'react'
import axios from 'axios'
import AllExpenditure from '../components/contents/allExpenditure'
import DailyExpenditureTextGraph from '../components/contents/mustExpenditure/textGraph.tsx'

interface Summary {
  income: number
  expense: number
  balance: number
}

const API_URL = import.meta.env.VITE_API_URL ?? '/api'

export default function Dashboard() {
  const [summary, setSummary] = useState<Summary>({ income: 0, expense: 0, balance: 0 })
  const [loading, setLoading] = useState(true)

  useEffect(() => {
    axios
      .get<Summary>(`${API_URL}/summary`)
      .then((res) => setSummary(res.data))
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
      <AllExpenditure/>
      <h2 className="text-2xl font-bold text-gray-800 mb-6">ダッシュボード</h2>
      <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div className="bg-white rounded-xl shadow p-6">
          <p className="text-sm text-gray-500 mb-1">収入</p>
          <p className="text-2xl font-bold text-green-600">{fmt(summary.income)}</p>
        </div>
        <div className="bg-white rounded-xl shadow p-6">
          <p className="text-sm text-gray-500 mb-1">支出</p>
          <p className="text-2xl font-bold text-red-500">{fmt(summary.expense)}</p>
        </div>
        <div className="bg-white rounded-xl shadow p-6">
          <p className="text-sm text-gray-500 mb-1">残高</p>
          <p className="text-2xl font-bold text-indigo-600">{fmt(summary.balance)}</p>
        </div>
      </div>
      <div className='h-200 w-1/2 space-y-1 space-x-3 border m-5'>
        <DailyExpenditureTextGraph/>
      </div>
    </div>
  )
}
