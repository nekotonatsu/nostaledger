import { useState } from 'react'
import AddTagForm from '../contents/form/addTagForm'

interface Props {
    headerMessage: string
    to: string
    apiEndpoint: string
}

export default function TagHeader({ headerMessage, apiEndpoint }: Props) {
    const [isOpen, setIsOpen] = useState(false)

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
                <div className="absolute left-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-100 p-4 z-50">
                    <AddTagForm
                        apiEndpoint={apiEndpoint}
                        onCancel={() => setIsOpen(false)}
                    />
                </div>
            )}
        </div>
    )
}
