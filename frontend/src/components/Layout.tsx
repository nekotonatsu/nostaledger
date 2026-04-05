import { Outlet, NavLink, useNavigate } from 'react-router-dom'
import { useAuth } from '../contexts/AuthContext'

export default function Layout() {
  const { user, logout } = useAuth()
  const navigate = useNavigate()

  const handleLogout = async () => {
    await logout()
    navigate('/login', { replace: true })
  }

  return (
    <div className="min-h-screen bg-gray-50">
      <header className="bg-white shadow-sm">
        <div className="max-w-5xl mx-auto px-4 py-4 flex items-center justify-between">
          <h1 className="text-xl font-bold text-indigo-600">NostaleEdger</h1>
          <nav className="flex gap-4 items-center">
            <NavLink
              to="/"
              end
              className={({ isActive }) =>
                isActive
                  ? 'text-indigo-600 font-semibold'
                  : 'text-gray-600 hover:text-indigo-500'
              }
            >
              ダッシュボード
            </NavLink>
            <NavLink
              to="/transactions"
              className={({ isActive }) =>
                isActive
                  ? 'text-indigo-600 font-semibold'
                  : 'text-gray-600 hover:text-indigo-500'
              }
            >
              取引一覧
            </NavLink>
            <span className="text-sm text-gray-500">{user?.name}</span>
            <button
              onClick={handleLogout}
              className="text-sm text-gray-500 hover:text-red-500"
            >
              ログアウト
            </button>
          </nav>
        </div>
      </header>
      <main className="max-w-5xl mx-auto px-4 py-8">
        <Outlet />
      </main>
    </div>
  )
}
