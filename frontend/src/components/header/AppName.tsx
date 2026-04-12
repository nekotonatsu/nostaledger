import { useState } from 'react'
import { useNavigate } from 'react-router-dom'
import { useAuth } from '../../contexts/AuthContext'

export default function AppName() {
    const [isOpen, setIsOpen] = useState(false)
    const { logout } = useAuth()
    const navigate = useNavigate()

    const handleLogout = async () => {
        await logout()
        navigate('/login', { replace: true })
    }

    return (
        <div className="relative">
            <button
                onClick={() => setIsOpen(!isOpen)}
                className="flex items-center gap-2 text-indigo-600 font-bold"
            >
                NostaleEdger
                <span className="text-gray-500 text-lg">{isOpen ? '✕' : '☰'}</span>
            </button>

            {isOpen && (
                <div className="absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-lg border border-gray-100">
                    <button
                        onClick={handleLogout}
                        className="w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-gray-50 rounded-lg"
                    >
                        ログアウト
                    </button>
                </div>
            )}
        </div>
    )
}
