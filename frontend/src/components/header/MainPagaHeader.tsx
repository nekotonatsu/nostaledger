import { useState } from 'react'
import TagHeader from './TagHeader'
import AppName from './AppName'
import ExpenditureHeader from './ExpenditureHeader'

export default function AllPageHeader() {
    const [openForm, setOpenForm] = useState<string | null>(null)

    const toggle = (key: string) => (val: boolean) => setOpenForm(val ? key : null)

    return (
        <div className="flex items-center w-full">
            <div className="flex gap-4 flex-wrap">
                <ExpenditureHeader
                    headerMessage='確定支出追加・削除'
                    apiEndpoint='must-expenditures'
                    isOpen={openForm === 'must-expenditures'}
                    setIsOpen={toggle('must-expenditures')}
                />
                <ExpenditureHeader
                    headerMessage='支出追加・削除'
                    apiEndpoint='daily-expenditures'
                    isOpen={openForm === 'daily-expenditures'}
                    setIsOpen={toggle('daily-expenditures')}
                />
                <TagHeader
                    headerMessage='必須出資タグ追加・削除'
                    apiEndpoint='must-expenditure-tags'
                    isOpen={openForm === 'must-expenditure-tags'}
                    setIsOpen={toggle('must-expenditure-tags')}
                />
                <TagHeader
                    headerMessage='タグ追加・削除'
                    apiEndpoint='daily-expenditure-tags'
                    isOpen={openForm === 'daily-expenditure-tags'}
                    setIsOpen={toggle('daily-expenditure-tags')}
                />
            </div>
            <div className="ml-auto shrink-0 pl-4">
                <AppName/>
            </div>
        </div>
    )
}
