import { Navigate, Outlet } from 'react-router-dom'
import { useAuth } from '../contexts/AuthContext'

export default function PrivateRoute() {
  const { user, loading } = useAuth()

  if (loading) {
    return <p className="text-center text-gray-400 py-12">読み込み中...</p>
  }

  return user ? <Outlet /> : <Navigate to="/login" replace />
}
