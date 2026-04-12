import { Outlet } from 'react-router-dom'
import MainPageHeader from './header/MainPagaHeader'

export default function Layout() {
  return (
    <div className="min-h-screen bg-gray-50">
      <header className="bg-white shadow-sm">
          <div className='max-w-5xl mx-auto px-4 py-4 flex w-full'>
            <MainPageHeader/>
          </div>
      </header>
      <main className="max-w-5xl mx-auto px-4 py-8">
        <Outlet />
      </main>
    </div>
  )
}
