import { createContext, useContext, useEffect, useState } from 'react'
import axios from 'axios'

const API_URL = import.meta.env.VITE_API_URL ?? '/api'

axios.defaults.withCredentials = true

interface User {
  id: number
  name: string
  email: string
}

interface AuthContextType {
  user: User | null
  loading: boolean
  login: (email: string, password: string) => Promise<void>
  register: (name: string, email: string, password: string, passwordConfirmation: string) => Promise<void>
  logout: () => Promise<void>
}

const AuthContext = createContext<AuthContextType | null>(null)

export function AuthProvider({ children }: { children: React.ReactNode }) {
  const [user, setUser] = useState<User | null>(null)
  const [loading, setLoading] = useState(true)

  useEffect(() => {
    axios
      .get<{ user: User }>(`${API_URL}/auth/me`)
      .then((res) => setUser(res.data.user))
      .catch(() => setUser(null))
      .finally(() => setLoading(false))
  }, [])

  const login = async (email: string, password: string) => {
    await axios.get('/sanctum/csrf-cookie')
    const res = await axios.post<{ user: User }>(`${API_URL}/auth/login`, { email, password })
    setUser(res.data.user)
  }

  const register = async (name: string, email: string, password: string, passwordConfirmation: string) => {
    await axios.get('/sanctum/csrf-cookie')
    const res = await axios.post<{ user: User }>(`${API_URL}/auth/register`, {
      name,
      email,
      password,
      password_confirmation: passwordConfirmation,
    })
    setUser(res.data.user)
  }

  const logout = async () => {
    await axios.post(`${API_URL}/auth/logout`)
    setUser(null)
  }

  return (
    <AuthContext.Provider value={{ user, loading, login, register, logout }}>
      {children}
    </AuthContext.Provider>
  )
}

export function useAuth() {
  const ctx = useContext(AuthContext)
  if (!ctx) throw new Error('useAuth must be used within AuthProvider')
  return ctx
}
